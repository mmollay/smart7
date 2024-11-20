/**
 * \file main.cpp
 * \brief WebCapt - a Qt WebKit web page capturing as a service
 *
 * This program is intended to be run as FastCGI. It loads a URL in WebKit, captures its
 * contents and sends the output to the client in the desired data format.
 * Captures are cached on disk and removed after a retention time that can be defined.
 * Webcapt reads its configuration from webcat.conf.
 *
 * Parameters: func     Function (screenshot [default], dom, links, test, clearcache, exit)
 *             app      Application ID (for logging)
 *             url      URL to process
 *             cache    A value of 0 means "don't use cache"
 *             file     Path to a local filename. If missing, the content is returned;
 *                      if set, the file is produced on the server and "OK" is returned.
 *
 *   The following parameters are applicable only for "func=screenshot":
 *             format   Target data format (jpeg, png, ...)
 *             width    Width of the image to produce
 *             height   Height of the image to produce
 *             vwidth   Viewport width in pixels (overrules config)
 *             vheight  Viewport height in pixels (overrules config)
 *             mark     Mark links in image (debug)
 *
 * If width/height are omitted, the default viewport geometry as defined in webcapt.conf
 * is used for the image. If no format is given, "jpg" is assumed for screenshot mode,
 * "xml" for DOM mode and "csv" for hyperlink export mode.
 *
 * The parameter 'app' is mandatory and must correspond to a definition in the <apps>
 * section of webcapt.conf. The 'url' parameter is - of course - mandatory and has to be
 * URL-encoded properly by the caller.
 *
 * Functions:
 *             screenshot    Render web site to desired output format
 *             dom           Export XML representation of the web page's DOM tree
 *             links         Export all hyperlinks and their coordinates as CSV
 *                           ('format' can be "csv" or "excel" here)
 *             test          Return "OK" if the FCGI is active (can be used for monitoring)
 *             clearcache    Remove all items from cache and return "OK"
 *             exit          Force a reload of the FCGI and return "OK"
 *             
 * On successful completion, the created file's content is returned.
 * If an error occured, a plain text page is returned which contains the error description.
 *
 * Online compression with gzip is triggered by using ".gz" as format suffix, e.g. ".bmp.gz".
 *
 * NB: Because of QWebKit, an X server is required.
 * Xvfb can be started the following way (as root):
 *    # Xvfb :1 -screen 0 1280x1024x24 &
 *
 * \author Bert Klauninger
 * \version 0.2.0
 * \cond changelog
 *    2012-11-05 - Created
 *    2012-11-06 - Tidying up code
 *    2012-11-07 - Implemented FCGI integration
 *    2012-11-12 - Added protocol guessing
 *                 Added cURL loader for errorneous pages
 *                 Implemented cache clean-up
 *    2012-11-14 - Using QWebView now
 *    2012-11-16 - Added check for 'app' parameter
 *    2012-11-19 - Images are scaled rather than clipped now
 *                 Added gzip support
 *    2012-11-20 - Introduced parameter 'func'
 *                 Parameters are passed via 'Parameters' objects now
 *    2012-11-23 - Using ssi::File now
 *    2012-11-26 - Using implicit file locking
 *    2014-10-02 - Added possibility to save output to local server file
 *    2015-09-13 - Fixed GET/POST parameter issues
 *    2015-09-15 - Added vwidth and vheight
 * \endcond
 *
 */

#include <QApplication>
#include <QSslError>

#include "fcgio.h"

#include "ssi/array.h"
#include "ssi/error.h"
#include "ssi/string.h"
#include "ssi/app/curl.h"
#include "ssi/app/logfile.h"
#include "ssi/app/xml.h"

#include "filestore.h"
#include "webcapt.h"
#include "main.h"
#include "parameters.h"


using namespace std;
using ssi::Array;
using ssi::Curl;
using ssi::Error;
using ssi::File;
using ssi::LogFile;
using ssi::String;
using ssi::XmlDocument;


/*** Implementation of class MyApplication ***/

void MyApplication::error(const String &msg, const Parameters &p) {
	/**
	 * error(): Send error message to client (plain text)
	 */
	if (! p.req) {
		return;
	}
	log(LOG_ERROR, msg, p);
	FCGX_PutS("Content-Type: text/plain\r\n\r\n", p.req->out);
	FCGX_PutS("ERROR: ", p.req->out);
	FCGX_PutS(msg.c_str(), p.req->out);
	FCGX_FFlush(p.req->out);
}

void MyApplication::ok(const Parameters &p) {
	if (! p.req) {
		return;
	}
	FCGX_PutS("Content-Type: text/plain\r\n\r\n", p.req->out);
	FCGX_PutS("OK\n", p.req->out);
	FCGX_FFlush(p.req->out);
}

bool MyApplication::output(const Parameters &p) {
	/**
	 * output(): Send the file 'file' to client
	 */
	if (! p.req) {
		return false;
	}
	String file = myStore.getFileName(p);
	String mime = "Content-Type: ";
	
	if (p.format.endsWith(".gz")) {
		/* If a zipped format is requested, we return an attachment */
		mime += "application/gzip\r\n";
		mime += "Content-Disposition: attachment; filename=" +
				file.afterLast('/') + "\r\n";
				
	} else if ((p.format == "excel") || (p.format == "csv")) {
		/* For csv formats, we also return an attachment */
		mime += "text/csv\r\n";
		mime += "Content-Disposition: attachment; filename=" +
				file.afterLast('/').beforeLast('.') + ".csv\r\n";
				
	} else if (p.format == "xml") {
		mime += "application/xml\r\n";
		mime += "Content-Disposition: attachment; filename=" +
				file.afterLast('/').beforeLast('.') + ".xml\r\n";
				
	} else {
		if (String("html|itext|rtree").contains(p.format)) {
			mime += "text/" + p.format;
		} else if (p.format == "pdf") {
			mime += "application/pdf";
		} else {
			mime += "image";
			if (p.format == "tif") {
				mime += "/tiff";
			} else if (p.format == "jpg") {
				mime += "/jpeg";
			} else {
				mime += '/' + p.format;
			}
		}
		mime += "\r\n";
	}

	/* Read file at once */
	try {
		long int filesize = myStore.getFileSize(file);
		
		if (filesize < 1) {
			error("cannot open file in cache: " + file, p);
			return false;
		}
		char *buffer = new char[filesize];
		myStore.readFile(file, buffer);

		/* Write HTTP header */
		String len = "Content-Length: " + String(filesize) + "\r\n";
		FCGX_PutS(mime.c_str(), p.req->out);
		FCGX_PutS(len.c_str(), p.req->out);
		FCGX_PutS("\r\n", p.req->out);

		/* Write data */
		FCGX_PutStr(buffer, filesize, p.req->out);
		FCGX_FFlush(p.req->out);
		
		/* Release buffer */
		delete[] buffer;
		
	} catch (Error e) {
		error("cannot read file from cache: " + e.getMessage(), p);
		return false;
	}
	
	return true;
}

bool MyApplication::store(const Parameters &p) {
	/**
	 * store(): Create a local copy of the file
	 */
	if (! p.req) {
		return false;
	}
	
	String src = myStore.getFullPath(myStore.getFileName(p));
	String dst = p.file;

	try {
		File::copy(src, dst);
	} catch (Error e) {
		error("cannot copy file from cache to local file: " + e.getMessage(), p);
		return false;
	}
	
	ok(p);
	return true;
}

void MyApplication::debug(const String &msg, const Parameters &p) {
	if (myLog.isOpen()) {
		myLog.log(LOG_DEBUG, (msg + " " + p.id).trim());
	}
}

void MyApplication::log(int level, const String &msg, const Parameters &p) {
	if (myLog.isOpen()) {
		myLog.log(level, (msg + " " + p.id).trim());
	}
}

String MyApplication::capture(const Parameters &p) {
	/**
	 * capture(): Render the web site 'url' to the desired image format
	 */
	if (p.url.empty()) {
		return "";
	}
	
	/* Check if we have this image in cache / can produce it from master image */
	String file;
	if (! p.noCache) {
		file = myStore.lookup(p);
		if (! file.empty()) {
			return file;
		}
	}
	
	/* No - not in cache */
	bool success = myWc->loadUrl(p.url, p.jsEnabled);

	if ((! success) && (! p.url.contains("file://"))) {
		/* Load error - try getting page via cURL */
		debug("trying cURL fallback", p);
		try {
			myCurl.getUrl(p.url);

			if (myCurl.getHttpCode() == 200) {
				String html = myCurl.getBody();

				/* Insert base URL for relative links */
				String base = p.url.before("://") + "://" +
						p.url.between("://", "/");
				if (! html.lowcase().contains("<base href")) {
					html = html.strReplace("<head>",
							"<head>\n<base href=\"" + base + "\" />");
					html = html.strReplace("<HEAD>",
							"<head>\n<base href=\"" + base + "\" />");
				}

				/* Write HTML to temp file */
				String tempfile = "curl_" + String::random(8) + ".html";
				myStore.writeFile(tempfile, html.c_str(), html.length());

				/* Load file */
				debug("trying to load temp file " + tempfile, p);
				success = myWc->loadUrl("file://" +
						myStore.getFullPath(tempfile), p.jsEnabled);

				/* Remove temp file */
				myStore.remove(tempfile);
			} else {
				debug("cURL fallback failed: HTTP error " +
						myCurl.getHttpCode(), p);
			}

		} catch (Error e) {
			debug("cURL fallback failed: " + e.getMessage(), p);
		}
	}

	if (success) {
		if (! p.noCache && FileStore::isBitmap(p.format)) {
			/* Store master image */
			Parameters p1 = p;
			p1.iwidth = myConf.get("/wcconfig/vwidth").toInt();
			p1.iheight = myConf.get("/wcconfig/vheight").toInt();
			p1.format = myConf.get("/wcconfig/master");

			/* Determine if master image should be zipped */
			bool mzipped = false;
			if (p1.format.endsWith(".gz")) {
				mzipped = true;
				p1.format = p1.format.section(0, -3);
			}

			String master = myStore.getFileName(p1);

			debug("saving master image to " + master, p1);
			if (myWc->capture(myStore.getFullPath(master), p1.format,
					p1.vwidth, p1.vheight, p1.mark)) {
				/* If master image format is compressed, perform the compression here */
				if (mzipped) {
					p1.format += ".gz";
					String zipped_master = myStore.getFileName(p1);
					debug("compressing master file " + zipped_master, p1);
					myStore.gzip(master, zipped_master);
					myStore.remove(master);
				}
				
				debug("converting master file", p1);
				file = myStore.lookup(p);
				if (file.empty()) {
					error("master image could not be converted", p1);
				}
				
				
			} else {
				/* If capturing was not successful, try again without JavaScript */
				if (p.jsEnabled) {
					debug("trying again with JavaScript disabled", p);
					Parameters p1 = p;
					p1.jsEnabled = false;
					file = capture(p1);
				} else {
					error("could not capture URL " + p.url, p);
				}
			}
			
		} else {
			/* Not a bitmap --> capture it directly */
			file = myStore.getFileName(p);
			if (p.format.endsWith(".gz")) {
				Parameters p1 = p;
				p1.format = p1.format.section(0, -3);
				String rawfile = myStore.getFileName(p1);
				if (! myWc->capture(myStore.getFullPath(rawfile),
						p1.format, p1.iwidth, p1.iheight, p1.mark)) {
					file = "";
					error("could not capture URL " + p.url, p);
				} else {
					myStore.gzip(rawfile, file);
					myStore.remove(rawfile);
				}
				
			} else {
				if (! myWc->capture(myStore.getFullPath(file), p.format,
						p.iwidth, p.iheight, p.mark)) {
					file = "";
					error("could not capture URL " + p.url, p);
				}
			}
		}

	} else {
		error("could not load URL " + p.url, p);
	}

	return file;
}

bool MyApplication::process(FCGX_Request &req) {
	/**
	 * process(): Process one HTTP request.
	 *    If the FCGI loop should be exited, false is returned, otherwise true.
	 */
	String file;
	String query;
	String id;
	Parameters p;
	p.req = &req;

	try {
		/* Cache clean-up */
		if ((myCleanUpInterval > 0) && (myNextCleanUp < ssi::now())) {
			myStore.cleanUp();
			myNextCleanUp = ssi::now() + myCleanUpInterval;
			debug("next cleanup: " + String::fromTime(myNextCleanUp), p);
		}
	} catch (Error e) {
		log(E_ERROR, "cleanUp(): " + e.getMessage(), p);
	}

	try {
		/* Receive HTTP request */
		
		/* GET Request */
		char *par = FCGX_GetParam("QUERY_STRING", req.envp);
		if (par && *par) {
			query = par;
		} else {			
			char *lens = FCGX_GetParam("CONTENT_LENGTH", req.envp);
			if (! lens || *lens == '0') {
				error("no parameters received", p);
				return true;
			} else {
				/* POST Request */
				long int len = strtol(lens, &lens, 10);

				char *tmp = new char[len + 1]();
				FCGX_GetStr(tmp, len, req.in);
				query = tmp;
				delete[] tmp;
			}
		}

		/* Get client IP */
		String ip = FCGX_GetParam("REMOTE_ADDR", req.envp);
		p.id = "[" + ip + "]";

		if ((myWhiteList.count() > 0) && ! myWhiteList.check(ip)) {
			error("access denied", p);
			return true;
		}
		
		debug("query received: " + query, p);

		/* Get parameters from query */
		String arg_func;
		String arg_app;
		p.vwidth = myConf.get("/wcconfig/vwidth").toInt();
		p.vheight = myConf.get("/wcconfig/vheight").toInt();
		p.req = &req;

		Array<String> values = query.explode('&');
		for (int i = 0; i < values.count(); ++i) {
			if (values[i].contains('=')) {
				String name = values[i].before('=').lowcase();
				String value = values[i].after('=');

				if (name == "func") {
					arg_func = value.lowcase();
				} else if (name == "app") {
					arg_app = value.urlDecode().lowcase();
				} else if (name == "url") {
					p.url = value.urlDecode();
				} else if (name == "file") {
					p.file = value.urlDecode();
				} else if (name == "format") {
					p.format = value.lowcase();
				} else if (name == "width") {
					p.iwidth = value.toInt();
				} else if (name == "height") {
					p.iheight = value.toInt();
				} else if (name == "vwidth") {
					p.vwidth = value.toInt();
				} else if (name == "vheight") {
					p.vheight = value.toInt();
				} else if (name == "mark") {
					p.mark = true;
				} else if (name == "cache") {
					p.noCache = (value.toInt() == 0);
				}
			}
		}
		
		/* Make sure iwidth/iheight/vwidth/vheight have meaningful values */
		p.normalize();

		/* Generate an ID which is composed from app and IP address */
		p.id = '[';
		if (! arg_app.empty()) {
			p.id += arg_app + '@';
		}
		p.id += ip + ']';
		
		/* Handle special commands here */
		if (arg_func == "test") {
			/* Test command */
			debug("test scheduled", p);
			ok(p);
			return true;
			
		} else if (arg_func == "exit") {
			/* Exit current FCGI instance */
			log(LOG_INFO, "exit scheduled", p);
			ok(p);
			return false;
			
		} else if (arg_func == "clearcache") {
			/* Clean cache now */
			log(LOG_INFO, "cleaning cache", p);
			myStore.clear();
			ok(p);
			return true;
		}		
		
		/* Some intergity checks and default assignments */
		if (p.url.empty()) {
			error("parameter 'url' is missing", p);
			return true;
		}
		
		if (! p.url.contains("://")) {
			/* No protocol specified - assume HTTP */
			p.url = "http://" + p.url;
		}

		if (arg_func.empty()) {
			arg_func = "screenshot";
		}		
		
		if (arg_app.empty()) {
			error("parameter 'app' is missing", p);
			return true;
		}
		
		/* Only applications defined in the config are allowed */
		bool app_ok = false;
		for (int i = 0; i < myApps.count(); ++i) {
			if (myApps[i].lowcase() == arg_app.lowcase()) {
				app_ok = true;
			}
		}

		if (! app_ok) {
			error("value for parameter 'app' is invalid: " + arg_app, p);
			return true;
		}
		
		/** Execute the function **/
		
		if (arg_func == "screenshot") {
			/* Capture web site */
			if (p.format.empty()) {
				p.format = "jpeg";
			}
			
			if (FileStore::isBitmap(p.format) || p.format == "pdf") {
				debug("request parsed: " + p.url + "," + p.format + "," +
						String(p.iwidth) + "," + String(p.iheight), p);

				/* Load and render URL */
				file = capture(p);
			} else {
				error("unsupported format for screenshot: " + p.format, p);
				return true;
			}
			
		} else if (arg_func == "dom") {
			/* Export DOM tree */
			if (p.format.empty()) {
				p.format = "xml";
			}
			if (p.format == "xml") {
				file = capture(p);
			} else {
				error("unsupported format for DOM export: " + p.format, p);
			}
			
		} else if (arg_func == "links") {
			/* Export Hyperlinks CSV */
			if (p.format.empty()) {
				p.format = "csv";
			}
			if (FileStore::isCsv(p.format)) {
				file = capture(p);
			} else {
				error("unsupported format for hyperlink export: " + p.format, p);
			}
			
		} else {
			/* Unknown function */
			error("unknown function: " + arg_func, p);
		}
		
		/** Send output to client **/
		if (! file.empty()) {
			if (p.file.empty()) {
				/* Deliver file */
				debug("sending output to client", p);
				if (output(p)) {
					log(LOG_INFO, "request for " + p.url + " (" +
							p.format + "): Success", p);
				}
			} else {
				/* Write file to local (server) file system */
				debug("storing output locally", p);
				if (store(p)) {
					log(LOG_INFO, "request for " + p.url + " (" +
							p.format + "): Stored as " + p.file, p);
				}
			}
		}
		
		if (p.noCache) {
			/* Remove file if no caching */
			File::remove(myStore.getFullPath(myStore.getFileName(p)));
		}
		
	} catch (Error e) {
		/* Any exception within the FCGI loop should be logged but otherwise neglected */
		myLog.handle(e);
	
	} catch (exception e) {
		log(E_ERROR, e.what(), p);
	}

	return true;
}

MyApplication::MyApplication(const String &config, int argc, char **argv) {
	/**
	 * Constructor: Read config file an initialize everything
	 */
	try {
		/* Read config */
		myConf.parseFile(config);

		/* Set up logging */
		String lf = myConf.get("/wcconfig/logfile");
		int ll = myConf.get("/wcconfig/loglevel").toInt();

		if (lf.empty()) {
			throw Error(E_CRIT, "WCT-001", "missing logfile in " + config);
		}

		myLog.open(lf, ll);
		myLog.log(LOG_INFO, "application started - version " + String(WEBCAPT_VERSION));

		/* Set X11 display */
		String x11 = myConf.get("/wcconfig/x11display");
		if (x11.empty()) {
			throw Error(E_CRIT, "WCT-002", "missing x11display in " + config);
		}
		myLog.debug("setting virtual X11 display to " + x11);
		setenv("DISPLAY", x11.c_str(), 1);

		/* Initialize File Repository */
		String cache = myConf.get("/wcconfig/cachedir");
		if (cache.empty()) {
			throw Error(E_CRIT, "WCT-003", "missing cachedir in " + config);
		}
		myLog.debug("setting cache path to " + cache);
		myStore.setConfig(&myConf);
		myStore.setLogFile(&myLog);
		myStore.setPath(cache);
		
		/* Set cache retention policy */
		myStore.setRetention(myConf.get("/wcconfig/retention").toInt());
		myCleanUpInterval = myConf.get("/wcconfig/cleanup").toInt();

		if (myCleanUpInterval > 0) {
			myNextCleanUp = ssi::now();
		} else {
			myNextCleanUp = 0;
		}

		/* Get IP White List */
		myWhiteList = myConf.getAll("/wcconfig/whitelist/ip");

		/* Get allowed apps */
		myApps = myConf.getAll("/wcconfig/apps/app");
		
		for (int i = 0; i < myApps.count(); ++i) {
			myLog.debug("adding app id " + myApps[i]);
		}
		myLog.debug("creating QApplication");

		/* Initialize Qt stuff */
		myLog.debug("creating QApplication");
		myQt = new QApplication(argc, argv, true);
		myLog.debug("creating WebCapt");
		myWc = new WebCapt();
		myWc->setConfig(&myConf);
		myWc->setLogFile(&myLog);

		/* Initialize FastCGI */
		myLog.debug("initializing FastCGI");
		FCGX_Init();

	} catch (Error e) {
		/* An error during program initialization is always critical */
		if (myLog.isOpen()) {
			myLog.log(E_CRIT, e.getErrNo() + ": " + e.getMessage());
			myLog.close();
		}
		cerr << "Critical error: " << e.getErrNo() << ": " << e.getMessage() << endl;
		exit(1);
	}
}

MyApplication::~MyApplication() {
	/**
	 * Destructor: Free resources
	 */
	myLog.debug("deleting WebCapt object");
	delete myWc;

	myLog.debug("deleting QApplication object");
	delete myQt;

	myLog.log(LOG_INFO, "application terminated");
}

void MyApplication::run() {
	/**
	 * run(): Main FCGI loop
	 *    Now that's trivial ;)
	 */
	int max_requests = myConf.get("/wcconfig/maxrequests").toInt();
	int requests = 0;
	FCGX_Request req;
	FCGX_InitRequest(&req, 0, 0);

	/* FCGI Accept loop */
	while ((FCGX_Accept_r(&req) == 0) && process(req)) {
		if (max_requests > 0) {
			++requests;
			if (requests >= max_requests) {
				myLog.log(LOG_INFO, String("maximal number of requests reached") +
						" - instance is terminating");
				break;
			}
		}
	}
}


/*** MAIN ***/

int main(int argc, char **argv) {
	/*
	 * Although we do not support command line arguments with an FCGI,
	 * argc and argv are necessary to create the QApplication object
	 */
	MyApplication app("./webcapt.conf", argc, argv);
	app.run();

	return 0;
}

/// HIER KÖNNTE IHRE WERBUNG STEHEN!
