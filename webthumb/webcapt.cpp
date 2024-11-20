/**
 * \file webcapt.cpp 
 * \brief Class for rendering web pages synchronously
 *
 * \author Bert Klauninger
 * \version 0.2.0
 * \cond changelog
 *    2012-11-05 - Created
 *    2012-11-06 - Tidying up code
 *    2012-11-07 - Put into separate cpp/h files
 *    2012-11-12 - Added rendering of local files
 *                 Bug fix in QEventLoop
 *    2012-11-14 - Changed to use QWebView
 *                 Using static objects whenever possible
 *    2012-11-15 - Added frame marking and link export
 *    2012-11-19 - Changed width/height scaling
 *                 Link export produces only absolute links now
 *    2012-11-23 - Removed dependency upon InitialLayoutComplete
 *    2013-01-31 - Replaced STL functionality by libbk
 * \endcond
 *
 */

#include <QApplication>
#include <QtWebKit>
#include <QtGui>
#include <QSvgGenerator>
#include <QPrinter>
#include <QTextStream>
#include <QTimer>
#include <QByteArray>
#include <QNetworkRequest>
#include <QNetworkReply>
#include <QSslError>

#include "webcapt.h"

#include "ssi/string.h"
#include "ssi/app/logfile.h"
#include "ssi/app/xml.h"

#define NO_DEBUG
#define NO_CHECK

#ifdef STATIC_PLUGINS
Q_IMPORT_PLUGIN(qjpeg)
Q_IMPORT_PLUGIN(qgif)
Q_IMPORT_PLUGIN(qtiff)
Q_IMPORT_PLUGIN(qsvg)
Q_IMPORT_PLUGIN(qmng)
Q_IMPORT_PLUGIN(qico)
#endif

using namespace std;
using ssi::File;
using ssi::String;
using ssi::XmlDocument;
using ssi::eol;

/*** Aux routines ***/

inline String q2bk(const QString &s) {
	/**
	 * q2bk(): Convert QString to String
	 */
	return s.toUtf8().data();
}

inline QString bk2q(const String &s) {
	/**
	 * bk2q(): Convert String to QString
	 */
	return s.c_str();
}


/*** Implementation of class WebCapt ***/

void WebCapt::sslErrors(QNetworkReply* reply, const QList<QSslError> &errors) {
	/**
	 * sslErrors(): Slot to ignore all SSL errors
	 */
    foreach (QSslError e, errors)
    {
        debug("SSL Error: " + q2bk(e.errorString()));
    }

    reply->ignoreSslErrors();
}

void WebCapt::urlChanged(const QUrl &url) {
	/**
	 * urlChanged(): Slot to check for empty URLs which mark an error
	 */
	debug("URL changed to " + q2bk(url.toString()));
	if (url.isEmpty() || (url.toString() == "about:blank")) {
		debug("URL is empty --> exiting");
		emit done();
	}
}

void WebCapt::loadFinished(bool ok) {
	/**
	 * loadFinished(): Slot which sets a flag when the whole page was loaded
	 */
	debug("load finished: " + String(ok ? "ok" : "error"));
	myDocumentComplete = ok;
	emit done();
}

void WebCapt::timeout() {
	/**
	 * timeout(): Slot to handle timeout:
	 *    Try to save what we have and exit.
	 */
	debug("Timeout occurred");
	emit done();
}

void WebCapt::replyFinished(QNetworkReply *reply) {
	/**
	 * replyFinished(): Slot for tracking success / network errors
	 */
	if(reply->error() != QNetworkReply::NoError) {
		debug("HTTP Error: " + String(reply->error()) + " (" +
				q2bk(reply->errorString()) + ")");
	} else {
		debug("HTTP OK: " + q2bk(reply->url().toString()));
	}
}

void WebCapt::debug(const String &msg) {
	/**
	 * debug(): Logs a debug message to logfile, if present
	 */
	if (myLog && myLog->isOpen()) {
		myLog->log(LOG_DEBUG, msg);
	}
}

WebCapt::WebCapt() {
	/**
	 * Constructor
	 */
	myView.page()->setNetworkAccessManager(&myManager);
	myLog = NULL;
	myConf = NULL;
	myDocumentComplete = false;
	
	/* Some settings */
	myView.page()->settings()->setAttribute(QWebSettings::PluginsEnabled, false);
	myView.page()->settings()->setAttribute(QWebSettings::FrameFlatteningEnabled, true);
}

WebCapt::~WebCapt() {
	/**
	 * Destructor: Clean up
	 */
}

void WebCapt::setLogFile(LogFile *log) {
	myLog = log;
}

void WebCapt::setConfig(XmlDocument *conf) {
	myConf = conf;
}

bool WebCapt::loadUrl(const String &url, bool jsEnabled) {
	/**
	 * loadUrl() - SYNCHRONOUS: Send an URL request to the WebPage object.
	 *    After sending the request, an event loop is started which
	 *    waits for a finished() signal from our object.
	 *    Returns true if load was successful.
	 */

	debug("loadUrl(\"" + url + "\")");

	/* Reset document state */
	myDocumentComplete = false;

	QUrl qurl;
	if (url.contains("file://")) {
		qurl = QUrl::fromLocalFile(bk2q(url.after("file://")));
	} else {
		qurl = QUrl::fromEncoded(bk2q(url).toUtf8().data());
	}

	QWebPage *page = myView.page();
	QWebFrame *frame = page->mainFrame();

	/* Hide scroll bars */
	frame->setScrollBarPolicy(Qt::Horizontal, Qt::ScrollBarAlwaysOff);
	frame->setScrollBarPolicy(Qt::Vertical, Qt::ScrollBarAlwaysOff);

	/* Set initial viewport size (3x4) for adaptive pages */
	page->setViewportSize(QSize(1024, 768));

	/* Set handler for SSL errors */
	QObject::connect(&myManager, SIGNAL(sslErrors(QNetworkReply*, const QList<QSslError> & )),
            this, SLOT(sslErrors(QNetworkReply*, const QList<QSslError> & )));

	/* Set handler for loadFinished */
	QObject::connect(page, SIGNAL(loadFinished(bool)), this, SLOT(loadFinished(bool)));

	/* Set handler for networkManager::finished */
	QObject::connect(&myManager, SIGNAL(finished(QNetworkReply*)),
			this, SLOT(replyFinished(QNetworkReply*)));

	/* Set handler for URL changes */
	QObject::connect(frame, SIGNAL(urlChanged(const QUrl &)),
			this, SLOT(urlChanged(const QUrl &)));

	/* Set timer for maximal waiting time */
	int timeout = 0;
	if (myConf) {
		timeout = myConf->get("/wcconfig/timeout").toInt();
	}

	QTimer timer;
	if (timeout > 0) {
		timer.setInterval(timeout);
		timer.setSingleShot(true);
		QObject::connect(&timer, SIGNAL(timeout()), this, SLOT(timeout()));
		timer.start();
	}

	/* Load URL using HTTP GET */
	myRequest.setUrl(qurl);
	myView.settings()->setAttribute(QWebSettings::JavascriptEnabled, jsEnabled);
	myView.load(myRequest, QNetworkAccessManager::GetOperation);

	/* Block until done() */
	QEventLoop loop;
	debug("before loop.exec()");
	QObject::connect(this, SIGNAL(done()), &loop, SLOT(quit()));
	loop.exec();
	loop.processEvents();

	/* Stop timer */
	timer.stop();
	QObject::disconnect(&timer, 0, this, 0);

	/* Disconnect all signals from our slots */
	QObject::disconnect(this, 0, &loop, 0);
	QObject::disconnect(frame, 0, this, 0);
	QObject::disconnect(page, 0, this, 0);
	QObject::disconnect(&myManager, 0, this, 0);

	debug("after loop.exec()");

	bool result = myDocumentComplete;
	debug("loadUrl(): " + (result ? String("ok") : String("failed")));

	return result;
}

bool WebCapt::getLinks(const String &file, int width, int height, bool excel) {
	/**
	 * getLinks(): Extract all hyperlinks (a href) from the current web site,
	 *    including geometry information. All coordinates are normalized so that
	 *    ('width', 'height') is mapped to (1.0, 1.0). Invisible links are omitted.
	 *    All relative links are prefixed with the base URL.
	 *
	 *    The file produced is in CSV format:
	 *        URL ; left ; top ; right; bottom
	 *
	 *    If 'excel' is true, a German MS-Excel compatible CSV is created.
	 */
	if ((width < 1) || (height < 1)) {
		debug("getLinks(): invalid width/height: " + String(width)
				+ "x" + String(height));
		return false;
	}
	
	File fout(file, File::faWrite);

	if (! fout) {
		return false;
	}

	/* Get document's base URL */
	QUrl base_url = myView.page()->mainFrame()->baseUrl();
	String base;
	
	if (base_url.isEmpty()) {
		base = q2bk(myView.page()->mainFrame()->url().toString());
		base = base.before("://") + "://" + base.between("://", '/');
	} else {
		base = q2bk(base_url.toString());
		if (base.endsWith('/')) {
			base--;
		}
	}
	debug("getLinks(): baseUrl is " + base);

	/* Traverse all links */
	QWebElementCollection coll = myView.page()->mainFrame()->findAllElements("a[href]");
	foreach (QWebElement e, coll) {
		String href = q2bk(e.attribute("href"));
		bool visible =
				(e.styleProperty("display", QWebElement::ComputedStyle) != "none") &&
				(e.styleProperty("visibility", QWebElement::ComputedStyle) != "hidden") &&
				(e.styleProperty("opacity", QWebElement::ComputedStyle).toFloat() != 0.0);

		/* Empty HREF attributes and invisible elements are ignored */
		if (visible && ! href.empty()) {
			int x1 = e.geometry().left();
			int y1 = e.geometry().top();
			int x2 = x1 + e.geometry().width();
			int y2 = y1 + e.geometry().height();

			/* Links with a rectangle area of 0 are ignored */
			if ((x1 != x2) && (y1 != y2)) {
				float x1_f = (float)x1 / (float)width;
				float y1_f = (float)y1 / (float)height;
				float x2_f = (float)x2 / (float)width;
				float y2_f = (float)y2 / (float)height;
				String geo = String(x1_f) + ';' + String(y1_f) + ';' + String(x2_f) + ';' + String(y2_f);

				/* Use base URL to convert relative links to absolute ones */
				if (! href.contains("://")) {
					if (href.startsWith('/')) {
						href = base + href;
					} else {
						href = base + '/' + href;
					}
				}

				if (excel) {
					if (href.containsAny("\";")) {
						href = "\"" + href.strReplace("\"", "\"\"") + "\"";
					}
					geo.replaceCharInPlace('.', ',');
				}

				fout << href << ';' << geo << eol;
			}
		}
	}
	fout.close();

	return true;
}

bool WebCapt::markLinks(QImage *img) {
	/**
	 * markLinks(): For each link in the current document, draw a rectangle on 'img'
	 *    (for debugging purposes)
	 */
	QPainter p;

	p.begin(img);
	p.setPen(QPen(QColor(100, 100, 255)));
	p.setBrush(QBrush(QColor(100, 100, 255), Qt::NoBrush));

	QWebElementCollection coll = myView.page()->mainFrame()->findAllElements("a[href]");
	foreach (QWebElement e, coll) {
		if (! e.attribute("href").isEmpty()) {
			p.drawRect(QRect(e.geometry().left(), e.geometry().top(),
					e.geometry().width(), e.geometry().height()));
		}
	}
	p.end();

	return true;
}

bool WebCapt::getDom(const String &file) {
	/**
	 * getDom(): Extract a dom tree of the given document
	 *    and write it to 'file'.
	 */
	if (file.empty()) {
		return false;
	}
	
	/* Write document to temp file */
	QWebElement root = myView.page()->mainFrame()->documentElement();
	String tempfile = file + ".tmp";
	File fout(tempfile, File::faWrite);
	
	if (! fout) {
		return false;
	}
	fout << q2bk(root.toOuterXml()) << eol;
	fout.close();
	
	/* Call "tidy" from the command line (dirty hack, I know) */
	if (myConf) {
		String cmdline = myConf->get("/wcconfig/tidy").trim() + ' ';
		cmdline += myConf->get("/wcconfig/tidyopts").normalize().trim().removeCdata();
		cmdline += "-output " + file + ' ' + tempfile;

		debug("tidying up file: " + cmdline);
		if (system(cmdline.c_str()) < 0) {
			return false;
		}
	}
	
	/* Test if output file was produced */
	bool result = File::exists(file);

	if (result) {
		File::remove(tempfile);
	}
	
	return result;
}

bool WebCapt::capture(const String& output, const String &format,
		int vwidth, int vheight, bool mark) {
	/**
	 * capture() - SYNCHRONOUS: Render the current contents of the WebPage
	 *    object to a file. Return true on success.
	 */
	debug("capture()");
	QWebPage *page = myView.page();
	QWebFrame *frame = page->mainFrame();

	if ((frame->url().isEmpty()) ||
			(frame->url().toString() == "about:blank")) {
		debug("URL is empty --> not saved");
		return false;
	}
	
	bool result = false;
	debug("saving URL " + q2bk(page->mainFrame()->url().toString()));

	/* Adjusting viewport */
	debug("content Size: " + String(frame->contentsSize().width()) +
			"x" + String(frame->contentsSize().height()));
	if (frame->contentsSize().height() < vheight) {
		vheight = frame->contentsSize().height();
		debug("Viewport height corrected to " + String(vheight));
	}
	page->setViewportSize(QSize(vwidth, vheight));
	
	/* Handle different output formats */
	if (format == "csv") {
		result = getLinks(output, vwidth, vheight, false);
		
	} else if (format == "excel") {
		result = getLinks(output, vwidth, vheight, true);
		
	} else if (format == "xml") {
		result = getDom(output);
		
	} else if (format == "svg") {
		QSvgGenerator svg;
		QPainter painter;
		svg.setFileName(bk2q(output));
		svg.setSize(page->viewportSize());
		painter.begin(&svg);
		frame->render(&painter,
				QRegion(0, 0, vwidth, vheight));
		painter.end();
		result = true;

	} else if ((format == "pdf") || (format == "ps")) {
		QPrinter printer;
		printer.setPageSize(QPrinter::A4);
		printer.setOutputFileName(bk2q(output));
		frame->print(&printer);
		result = true;

	} else if ((format == "itext") || (format == "rtree") || (format == "html")) {
		QFile file(bk2q(output));
		file.open(QIODevice::WriteOnly | QIODevice::Text);
		QTextStream s(&file);
		s.setCodec("utf-8");
		s << (format == "rtree" ? page->mainFrame()->renderTreeDump() :
			format == "itext"  ? page->mainFrame()->toPlainText() :
			format == "html" ? page->mainFrame()->toHtml() : "");
		result = true;

	} else {
		/* Default */
		QImage image(QSize(vwidth, vheight), QImage::Format_ARGB32_Premultiplied);
		image.fill(Qt::transparent);
		QPainter painter(&image);
		debug("rendering/clipping to " + String(vwidth) + "x" + String(vheight));
		frame->render(&painter, QRegion(0, 0, vwidth, vheight));
		frame->render(&painter);
		painter.end();

		/* Check if result image is empty */
		bool empty = true;
		const uchar c1 = *image.bits();
		const uchar *end = image.bits() + image.byteCount();
		for (uchar *c = image.bits(); c < end; ++c) {
			if (*c != c1) {
				empty = false;
				break;
			}
		}

		if (empty) {
			debug("result image is empty");
			return false;
		}

		/* DEBUG: Mark all hyperlinks */
		if (mark) {
			markLinks(&image);
		}

		result = image.save(bk2q(output), format.c_str());
	}

	debug("capture(): " + (result ? String("ok") : String("failed")));
	return result;
}
