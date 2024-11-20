/**
 * webcapt.h - Class for rendering web pages synchronously
 *
 * @author Bert Klauninger
 * @version 0.1.6
 * @changelog
 *    2012-11-05 - Created
 *    2012-11-06 - Tidying up code
 *    2012-11-07 - Put into separate cpp/h files
 *    2012-11-14 - Changed to use QWebView
 *                 Using static objects whenever possible
 *    2012-11-15 - Added frame marking and link export
 *    2013-01-31 - Replaced STL functionality by libbk
 *
 */

#include <QtWebKit>
#include <QNetworkRequest>

#include "ssi/string.h"
#include "ssi/app/logfile.h"
#include "ssi/app/xml.h"

using namespace std;
using ssi::LogFile;
using ssi::String;
using ssi::XmlDocument;


class WebCapt : public QObject {
	Q_OBJECT

	private slots:
		void sslErrors(QNetworkReply* reply,
				const QList<QSslError> &errors);
		void urlChanged(const QUrl &url);
		void loadFinished(bool ok);
		void timeout();
		void replyFinished(QNetworkReply* reply);

	private:
		QWebView myView;						// Web view (not shown)
		QNetworkAccessManager myManager;		// Network Access Manager
		QNetworkRequest myRequest;				// Network Request
		LogFile *myLog;							// Log file object
		XmlDocument *myConf;					// Configuration file object
		bool myDocumentComplete;				// Document completed?

		void debug(const String &msg);			// Write debug message to log file
		bool getLinks(const String &file,		// Extract all hyperlinks from the current web site
				int width,
				int height,
				bool excel = false);
		bool markLinks(QImage *img);			// Mark all hyperlinks with rectangles
		String traverseDom(						// Recursively traverse the main frame's DOM
				const QWebElement &e) const;
		bool getDom(const String &file);		// Extract DOM XML from the current main frame

	signals:
		void done();							// Signal: Current loading process has finished

	public:
		WebCapt();								// Constructor
		~WebCapt();								// Destructor
		void setLogFile(LogFile *log);			// Set log file object
		void setConfig(XmlDocument *conf);		// Set config file object
		bool loadUrl(const String &url,			// Load an URL to the WebPage object (synchronous)
				bool jsEnabled);
		bool capture(const String& output,		// Capture the URL's content to a file (synchronous)
				const String &format,
				int vwidth,
				int vheight,
				bool mark = true);
};
