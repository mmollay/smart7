/**
 * \file filestore.h
 * \brief Repository for files
 *
 * \author Bert Klauninger
 * \version 0.2.0
 * \cond changelog
 *    2012-10-31 - Created
 *    2012-11-07 - Separated into cpp and h file
 *    2012-11-09 - Changed name from FileRepository to ImageStore
 *                 Added image specific functions (libgd)
 *    2012-11-13 - Avoided that temp file names get too long
 *    2012-11-15 - Added clear()
 *    2012-11-19 - Added gzipping/unzipping of files
 *    2012-11-20 - Parameters are passed via 'Parameters' objects now
 *                 Changed name to FileStore
 *    2012-11-22 - Added locking on file and directory level
 *    2012-11-23 - Using bk::File instead of std::fstream now
 *    2013-01-31 - Replaced STL functionality by libbk
 * \endcond
 */

#ifndef __FILESTORE_H
#define __FILESTORE_H

#include "ssi/file.h"
#include "ssi/string.h"
#include "ssi/app/logfile.h"
#include "ssi/app/xml.h"

#include "parameters.h"

#define UINT32 unsigned int

#define SUPPORTED_FORMATS	"xml|csv|excel|svg|ps|pdf|itext|htm|html|rtree|png|jpg|jpeg|mng|tif|tiff|bmp|ppm|xbm|xpm"
#define BITMAP_FORMATS		"jpg|jpeg|png|mng|tif|tiff|gif|bmp|ppm|xbm|xpm"
#define CSV_FORMATS			"csv|excel"
#define LOCK_FILE			".lock"
#define LOCK_TIMEOUT		10	// sec


using namespace std;
using ssi::File;
using ssi::LogFile;
using ssi::String;
using ssi::XmlDocument;

/**
 * class FileStore: Class to manage a repository of images.
 *    Filenames are created automatically from URL, resolution and output format.
 *    cleanUp() will remove all files older that the specified retention time.
 *    getFile() allows to scale and convert an image on the fly and return the
 *    resulting binary data.
 */
class FileStore {
	private:
		String myPath;							///< Path to the cache dir
		int myRetention;						///< Time to keep files in repo
		LogFile *myLog;							///< Log file object
		XmlDocument *myConf;					///< XML config object

		static UINT32 getHash(const String &s);	///< Return numeric hash code for string


	public:

		/** Empty initializer */
		FileStore() : myRetention(-1), myLog(NULL), myConf(NULL) {}

		/** Check if 'format' is supported */
		static inline bool isSupported(const String &format) {
			return String(SUPPORTED_FORMATS).
					contains(format.lowcase().before(".gz"));
		}

		/** Check if 'format' is a bitmap format */
		static inline bool isBitmap(const String &format) {
			return String(BITMAP_FORMATS).contains(format.lowcase().before(".gz"));
		}

		/** Check if 'format' is a CVS format */
		static inline bool isCsv(const String &format) {
			return String(CSV_FORMATS).contains(format.lowcase().before(".gz"));
		}

		/** Set log file object */
		inline void setLogFile(LogFile *log) {
			myLog = log;
		}

		/** Set config object */
		inline void setConfig(XmlDocument *conf) {
			myConf = conf;
		}

		/** Log debug message */
		inline void debug(const String &msg) const {
			if (myLog && myLog->isOpen()) {
				myLog->log(LOG_DEBUG, msg);
			}
		}

		/** Set the path to temp. dir */
		inline void setPath(const String &path)	{
			myPath = path;
		}

		/** Set file retention time */
		inline void setRetention(int r) {
			myRetention = r;
		}

		/** Test if a file exists */
		inline bool exists(const String &file) const {
			return File::exists(myPath + '/' + file);
		}

		/** Get full path to a file */
		inline String getFullPath(
				const String &file) const {
			if (myPath.empty()) {
				return file;
			} else {
				return myPath + '/' + file;
			}
		}

		/** Return filename (excluding path) */
		String getFileName(const Parameters &p) const;

		/** Return file size or -1 */
		long int getFileSize(const String &file) const;

		/** Read a whole file at once */
		void readFile(const String &file, char *buf);

		/** Write a data block to a new file */
		void writeFile(const String &file, const char *buf, long int len);

		/** Convert an image to the desired format */
		bool convertImage(const String &src, const String &dst,
				const String &format, int width, int height);

		/** Check if the object is already in cache */
		String lookup(const Parameters &p);

		/** Remove a file from the directory */
		bool remove(const String &file);

		/** Remove old files from cache */
		void cleanUp();

		/** Remove ALL files from cache */
		void clear();

		/** Compress 'infile' to 'outfile' using gzip */
		void gzip(const String &infile, const String &outfile);

		/** Expand 'infile' to 'outfile' using gunzip */
		void gunzip(const String &infile, const String &outfile);

};

#endif
