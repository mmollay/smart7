/**
 * \file filestore.cpp
 * \brief Repository for images
 *
 * \author Bert Klauninger
 * \version 0.2.0
 * \cond changelog
 *    2012-10-31 - Created
 *    2012-11-07 - Separated into cpp and h file
 *                 Added image conversion using Qt
 *    2012-11-13 - Bugfix in cleanUp()
 *                 convertImage() keeps proportions now
 *    2012-11-19 - Added gzipping/unzipping of files
 *    2013-01-31 - Replaced STL functionality by libbk
 * \endcond
 */
 
#include <QImage>
#include <QImageWriter>

#include <dirent.h>
#include <errno.h>
#include <zlib.h>

#include "ssi/error.h"
#include "ssi/file.h"
#include "ssi/string.h"

#include "filestore.h"
#include "parameters.h"

using namespace std;
using ssi::Error;
using ssi::File;
using ssi::String;


UINT32 FileStore::getHash(const String &s) {
	/**
	 * getHash(): This is basically the Murmur 32 Hash function
	 */
	const char *data = s.c_str();
	const UINT32 len = s.length();
	const UINT32 seed = 0;
	const UINT32 nblocks = len / 4;
	UINT32 h = seed;
	UINT32 c1 = 0xcc9e2d51;
	UINT32 c2 = 0x1b873593;

	const UINT32 *blocks = (const UINT32 *)(data + nblocks*4);

	for(int i = -nblocks; i; i++) {
		UINT32 k = blocks[i];

		k *= c1;
		k = (k << 15) | (k >> 17);
		k *= c2;

		h ^= k;
		h = (h << 13) | (h >> 19);
		h = h * 5 + 0xe6546b64;
	}

	const char *tail = (const char *)(data + nblocks*4);
	UINT32 k = 0;

	switch(len & 3) {
		case 3: k ^= tail[2] << 16;
		case 2: k ^= tail[1] << 8;
		case 1: k ^= tail[0];
		k *= c1;
		k = (k << 15) | (k >> 17);
		k *= c2; h ^= k;
	};

	h ^= len;

	/* fmix */
	h ^= h >> 16;
	h *= 0x85ebca6b;
	h ^= h >> 13;
	h *= 0xc2b2ae35;
	h ^= h >> 16;
	
	return h;
}

String FileStore::getFileName(const Parameters &p) const {
	/**
	 * getFileName(): Produce some "quite unique" file name for a particular
	 *    parameter set ("quite unique" means that collisions could occur but
	 *    they are so rare that most likely we will never see one in the next
	 *    couple of billion years.
	 */
	String param = p.url + '@' + p.format + '@' +
			String(p.iwidth) + '@' + String(p.iheight) +
			"@" + (p.mark ? "mark" : "");
	debug("getFileName() for " + param);
	UINT32 key = getHash(param);
	return String(key) + '_' + p.url.between("://", "/").
			urlEncode().section(0, 30) + '.' + p.format;
}

long int FileStore::getFileSize(const String &file) const {
	/**
	 * getFileSize(): Return file size or -1
	 */
	File f(getFullPath(file));
	return f.size();
}

void FileStore::readFile(const String &file, char *buf) {
	/**
	 * readFile(): Read whole file at once into 'buf'
	 */
	File f(getFullPath(file), File::faRead, true);
	f.read(buf, f.size());
}

void FileStore::writeFile(const String &file, const char *buf, long int len) {
	/**
	 * writeFile(): Write a data block into a file
	 */
	File f(getFullPath(file), File::faWrite, true);
	f.write(buf, len);
}

bool FileStore::convertImage(const String &src, const String &dst,
		const String &format, int width, int height) {
	/**
	 * convertImage(): Convert image to the desired resolution / format
	 *     Returns true if successful.
	 */
	if (src == dst) {
		debug("no conversion needed");
		return true;
	}
	
	debug("converting image " + src + " to " + dst);
	
	if (src.empty() || dst.empty() || format.empty() ||
			(width < 1) || (height < 1)) {
		debug("empty image: " + src + ", " + dst + ", " + format + 
				", " + String(width) + ", " + String(height));
		return false;
	}
	
	if (! isBitmap(format)) {
		/* No bitmap format */
		debug("not a bitmap format: " + format);
		return false;
	}
	
	if (! exists(src)) {
		debug("source file does not exist: " + src);
		return false;
	}
	
	String s = src;
	String d = dst;
	String f = format;
	
	bool from_zipped = false;
	bool to_zipped = false;
	if (s.endsWith(".gz")) {
		/* Uncompress zipped input files beforehand */
		debug("unzipping file " + src);
		gunzip(s, s.section(0, -3));
		s = s.section(0, -3);
		from_zipped = true;
	}
	
	if (d.endsWith(".gz")) {
		/* Compress zipped output files afterwards */
		d = d.section(0, -3);
		f = format.section(0, -3);
		debug("target compression enabled");
		to_zipped = true;
	}
	 
	QImage *img = new QImage(getFullPath(s).c_str());
	int newheight = height * img->width() / width;
	if (newheight > img->height()) {
		newheight = img->height();
	}
	QImage clipped = img->copy(0, 0, img->width(), newheight);
	
	debug("image clipped");
	bool result = false;
	QImageWriter writer;
	writer.setFileName(getFullPath(d).c_str());
	writer.setFormat(f.c_str());
	
	if (img->width() != width) {
		QImage scaled = clipped.scaled(QSize(width, height), Qt::KeepAspectRatio,
			Qt::SmoothTransformation);
		debug("image scaled");
		result = writer.write(scaled);
	} else {
		result = writer.write(clipped);
	}
	
	if (result) {
		debug("image saved to " + d);
	} else {
		debug("cannot save image " + d + ": " + writer.errorString().toUtf8().data());
	}
	
	delete img;
	
	if (from_zipped) {
		/* If src is gzipped, we remove the extracted file */
		debug("unzipped source removed");
		remove(s);
	}
	
	if (result && to_zipped) {
		debug("zipping file " + dst);
		gzip(d, dst);
		debug("unzipped destination removed");
		remove(d);
	}
	
	debug("convertImage(): " + (result ? String("ok") : String("failed")));
	return result;
}

String FileStore::lookup(const Parameters &p) {
	/**
	 * lookup(): Check if the given object is already in the cache and
	 *    return its filename on success. If the desired format and
	 *    resolution has not been rendered yet, but a master image
	 *    (uncompressed BMP) is already here, the appropriate version
	 *    is created and its filename is returned. Otherwise, an empty
	 *    string is returned.
	 */
	 
	/* Is the image already available in the requested format and resolution? */
	String file = getFileName(p);
	
	if (! p.noCache) {
		debug("looking up file " + file);
		if (exists(file)) {
			debug("found in cache");
			return file;
		}
	}
	
	/* No bitmap --> can't be derived from master image */
	if (! isBitmap(p.format)) {
		return "";
	}
	
	/* Does a high-res master copy of the image already exist? */
	Parameters p1 = p;
	if (myConf) {
		p1.iwidth = myConf->get("/wcconfig/vwidth").toInt();
		p1.iheight = myConf->get("/wcconfig/vheight").toInt();
		p1.format = myConf->get("/wcconfig/master");
	}
	
	String master = getFileName(p1);
	debug("looking for master file " + master);
	if (exists(master)) {
		/* Render the desired output format to a new file */
		debug("master image found in cache");
		if (convertImage(master, file, p.format, p.iwidth, p.iheight)) {
			return file;
		}
	}
	
	/* File does not exist --> return empty string */
	debug("not found");
	return "";
}

bool FileStore::remove(const String &file) {
	/**
	 * remove(): Delete a file from the directory with implicit locking
	 */
	String path = getFullPath(file);
	File f(path, File::faWrite, true);
	bool result = File::remove(path);
	f.close();
	
	return result;
}

void FileStore::cleanUp() {
	/**
	 * cleanUp(): Remove all files from the repository which have not been accessed
	 *    in the last 'myRetention' secs
	 */
	if (myRetention < 0) {
			return;
	}

	/* Check all files in cache */
	DIR *d;

	if ((d = opendir(myPath.c_str())) == NULL) {
		throw Error(E_ERROR, "FIS-001", "Cannot access path " + myPath + ": " +
			String(strerror(errno)));
	}
	 
	struct dirent *ent;
	while ((ent = readdir(d)) != NULL) {
		if (ent->d_type == DT_REG) {
			/* Check file access time */
			String file = ent->d_name;
			if ((File::atime(file) + myRetention) < ssi::now()) {
				/* File has not been accessed for more than 'myRetention' secs */
				if (! remove(file)) {
				} else {
					throw Error(E_ERROR, "FIS-002", "Cannot remove file " +
							file + ": " + String(strerror(errno)));
				}
			}
		}
	}

	closedir(d);
}

void FileStore::clear() {
	/**
	 * clear(): Remove ALL files from cache
	 */
	DIR *d;
	if ((d = opendir(myPath.c_str())) == NULL) {
		throw Error(E_ERROR, "FIS-003", "Cannot access path " + myPath + ": " +
				String(strerror(errno)));
	}
	
	struct dirent *ent;
	while ((ent = readdir(d)) != NULL) {
		if (ent->d_type == DT_REG) {
			String file = ent->d_name;
			
			if (! remove(file)) {
				throw Error(E_ERROR, "FIS-004", "Cannot remove file " + file +
					": " + String(strerror(errno)));
			}
		}
	}
	
	closedir(d);
}

void FileStore::gzip(const String &infile, const String &outfile) {
	/**
	 * gzip(): Compress 'infile' and write stream to 'outfile'.
	 *    Both files are supposed to reside within the store directory.
	 *    Implicit locking.
	 */
	
	/* Open files and acquire locks */
	File fin(getFullPath(infile), File::faRead, true);
	File fout(getFullPath(outfile), File::faWrite, true);
	
	/* Associate GZIP stream with file descriptors */
	gzFile fp_out = gzdopen(fout.getFd(), "wb");
	char buffer[STRING_BUFFER_SIZE];
	
	while (! fin.eof()) {
		int len = fin.read(buffer, STRING_BUFFER_SIZE);
		if (gzwrite(fp_out, buffer, len) != len) {
			throw Error(E_ERROR, "FIS-005", "error compressing " + infile);
		}
	}
	
	gzclose(fp_out);
	fout.invalidate();
	
	/* 
	 * bk::File objects are usually closed automatically at destruction.
	 * invalidate() tells the object that the file descriptor was closed
	 * already by another function.
	 */
}

void FileStore::gunzip(const String &infile, const String &outfile) {
	/**
	 * gunzip(): Extract 'infile' and write stream to 'outfile'.
	 *    Both files are supposed to reside within the store directory.
	 *    Implicit locking.
	 */

	/* Open files and acquire locks */
	File fin(getFullPath(infile), File::faRead, true);
	File fout(getFullPath(outfile), File::faWrite, true);

	/* Associate GZIP streams with file descriptor */
	gzFile fp_in = gzdopen(fin.getFd(), "rb");
	char buffer[STRING_BUFFER_SIZE];
	
	while (! gzeof(fp_in)) {
		int len = gzread(fp_in, buffer, STRING_BUFFER_SIZE);
		if (len < 0) {
			throw Error(E_ERROR, "FIS-006", "error expanding " + infile);
		}
		
		fout.write(buffer, len);
	}
	
	gzclose(fp_in);
	fin.invalidate();
	
	/* 
	 * bk::File objects are usually closed automatically at destruction.
	 * invalidate() tells the object that the file descriptor was closed
	 * already by another function.
	 */
}
