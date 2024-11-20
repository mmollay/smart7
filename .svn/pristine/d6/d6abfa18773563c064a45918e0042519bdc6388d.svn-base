/**
 * \file parameters.h
 * \brief Container for application parameters
 *
 * \author Bert Klauninger
 * \version 0.2.0
 * \cond changelog
 *    2012-11-20 - Created
 *    2014-10-02 - Added parameter 'file'
 * \endcond
 */
 
#ifndef __PARAMETERS_H
#define __PARAMETERS_H

#include "fcgio.h"

#include "ssi/string.h"

using namespace std;
using ssi::String;

/**
 * Class Parameters: This container manages all parameters from one CGI requst
 */
class Parameters {
	private:
		void cloneFrom(const Parameters &rhs);
		
	public:
		String url;
		String file;
		String format;
		int vwidth;
		int vheight;
		int iwidth;
		int iheight;
		String id;
		bool mark;
		bool jsEnabled;
		bool noCache;
		FCGX_Request *req;
		
		Parameters() :
			vwidth(-1),
			vheight(-1),
			iwidth(-1),
			iheight(-1),
			mark(false),
			jsEnabled(true),
			noCache(false),
			req(NULL) {}
			
		Parameters(const Parameters &rhs);
		Parameters &operator=(const Parameters &rhs);
		bool operator==(const Parameters &rhs) const;
		bool operator!=(const Parameters &rhs) const;
		void normalize();
};

#endif
