/**
 * \file parameters.cpp
 * \brief Container for application parameters
 *
 * \author Bert Klauninger
 * \version 0.1.4
 * \cond changelog
 *    2012-11-20 - Created
 *    2014-10-02 - Added 'file' parameter
 * \endcond
 */
 
#include "fcgio.h"

#include "ssi/string.h"

#include "parameters.h"

using namespace std;
using ssi::String; 


 /*** Implementation of class Parameters ***/
 
Parameters::Parameters(const Parameters &rhs) {
	/**
	 * Copy Constructor
	 */
	cloneFrom(rhs);
}

Parameters &Parameters::operator=(const Parameters &rhs) {
	/**
	 * Assignment operator
	 */
	if (*this != rhs) {
		cloneFrom(rhs);
	}
	return *this;
}

bool Parameters::operator==(const Parameters &rhs) const {
	/**
	 * Equality operator
	 */
	return (url == rhs.url) && (file == rhs.file) && (format == rhs.format) &&
			(vwidth == rhs.vwidth) && (vheight == rhs.vheight) &&
			(iwidth == rhs.iwidth) && (iheight == rhs.iheight) &&
			(id == rhs.id) && (mark == rhs.mark) && 
			(jsEnabled == rhs.jsEnabled) && (noCache == rhs.noCache) &&
			(req == rhs.req);
}

bool Parameters::operator!=(const Parameters &rhs) const {
	/**
	 * Unequality operator
	 */
	return ! operator==(rhs);
}

void Parameters::cloneFrom(const Parameters &rhs) {
	/**
	 * cloneFrom(): Initialize object from 'rhs'
	 */
	url = rhs.url;
	file = rhs.file;
	format = rhs.format;
	vwidth = rhs.vwidth;
	vheight = rhs.vheight;
	iwidth = rhs.iwidth;
	iheight = rhs.iheight;
	id = rhs.id;
	mark = rhs.mark;
	jsEnabled = rhs.jsEnabled;
	noCache = rhs.noCache;
	req = rhs.req;
}

void Parameters::normalize() {
	/**
	 * normalize(): Calculate missing dimensions
	 */
	if (iwidth < 1) {
		if (iheight < 1) {
			iwidth = vwidth;
			iheight = vheight;
		} else {
			/* Scale width after height */
			iwidth = (vwidth * iheight) / vheight;
		}
	}

	if (iheight < 1) {
		/* Scale height after width */
		iheight = (vheight * iwidth) / vwidth;
	}
}
