/**
 * main.h - Class definition for webcapt main application
 *
 * @author Bert Klauninger
 * @version 0.2.0
 * @changelog
 *    2012-11-05 - Created
 *    2012-11-06 - Tidying up code
 *    2012-11-07 - Implemented FCGI integration
 *    2012-11-12 - Added protocol guessing
 *                 Added cURL loader for errorneous pages
 *                 Implemented cache clean-up
 *    2012-11-14 - Using QWebView now
 *    2012-11-16 - Added auto-termination after n requests
 *                 Added check for 'app' parameter
 *
 */

#ifndef __MAIN_H
#define __MAIN_H

#include <QApplication>

#include "fcgio.h"

#include "ssi/array.h"
#include "ssi/string.h"
#include "ssi/app/curl.h"
#include "ssi/app/logfile.h"
#include "ssi/app/xml.h"

#include "parameters.h"

using namespace std;
using ssi::Array;
using ssi::Curl;
using ssi::LogFile;
using ssi::String;
using ssi::XmlDocument;

#define WEBCAPT_VERSION "0.2.0 build 2017012401"

/**
 * Class MyApplication: Application logic
 */
class MyApplication {
	private:
		QApplication *myQt;						///< Qt Application (necessary for WebKit)
		WebCapt *myWc;							///< Qt Web Capture object
		FileStore myStore;						///< File repository
		LogFile myLog;							///< Log file
		XmlDocument myConf;						///< Config file
		Array<String> myWhiteList;				///< IP White List
		Array<String> myApps;					///< List of accepted apps
		Curl myCurl;							///< cURL page getter for fallback
		time_t myNextCleanUp;					///< Time for next cache clean up
		int myCleanUpInterval;					///< Interval for cache clean ups (sec)

		void ok(const Parameters &p);			///< Send plain text "OK" message
		void error(const String &msg,			///< Send an error message to client
				const Parameters &p);
		bool output(const Parameters &p);		///< Send output file to client
		bool store(const Parameters &p);		///< Write output to local file
		void debug(const String &msg,			///< Log debug message
				const Parameters &p);
		void log(int level, const String &msg,	///< Log a message
				const Parameters &p);
		String capture(const Parameters &p);	///< Load and render URL to specified format
		bool process(FCGX_Request &req);		///< Process a new FCGI request

	public:
		MyApplication(const String &config,		///< Initialize application
				int argc, char **argv);
		void run();								///< Start FCGI loop
		~MyApplication();						///< Destructor
};

#endif
