<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\http\iface;

/**
 *
 * @author gordonmcvey
 */
interface Response
{
	const
		
		/**
		 * HTTP 1.1 version string 
		 */
		HTTP_VER_11			= 'HTTP/1.1',
		
		/**
		 * HTTP response codes (Informational)
		 */
		INF_CONTINUE		= 100, // Continue
		INF_SWITCHING		= 101, // Switching protocols
		
		/**
		 * HTTP response codes (Successful response) 
		 */
		SUC_OK				= 200, // OK
		SUC_CREATED			= 201, // Created
		SUC_ACCEPTED		= 202, // Accepted
		SUC_NON_AUTH		= 203, // Non-Authoritative information
		SUC_NO_CONTENT		= 204, // No content
		SUC_RESET_CONTENT	= 205, // Reset content
		SUC_PARTIAL			= 206, // Partial content
		
		/**
		 * HTTP response codes (Redirection) 
		 */
		RDR_MULTIPLE		= 300, // Multiple choice
		RDR_PERMANENT		= 301, // Permanent redirect
		RDR_FOUND			= 302, // Found
		RDR_SEEOTHER		= 303, // See other
		RDR_NOTMODDED		= 304, // Not modified
		RDR_PROXY			= 305, // Use proxy
		RDR_RESERVED		= 306, // Unused code reserved for future use
		RDR_TEMPORARY		= 307, // Temporary redirect
		
		/**
		 * HTTP response codes (Client error) 
		 */
		ERR_C_BADREQ		= 400, // Bad request
		ERR_C_UNAUTHED		= 401, // Unauthorized
		ERR_C_PAYREQ		= 402, // Payment required
		ERR_C_FORBIDDEN		= 403, // Forbidden
		ERR_C_NOTFOUND		= 404, // Not found
		ERR_C_METHOD		= 405, // Method not allowed
		ERR_C_UNACCEPTABLE	= 406, // Not acceptable
		ERR_C_AUTH_PROXY	= 407, // Proxy authentication required
		ERR_C_TIMEOUT		= 408, // Request timeout
		ERR_C_CONFLICT		= 409, // Conflict
		ERR_C_GONE			= 410, // Gone
		ERR_C_NOLENGTH		= 411, // Length required
		ERR_C_PRECONDITION	= 412, // Precondition failed
		ERR_C_TOOLARGE		= 413, // Request entity too large
		ERR_C_URILONG		= 414, // Request URI too long
		ERR_C_MEDIATYPE		= 415, // Upsupported media type
		ERR_C_RANGE			= 416, // Requested range not satisfiable
		ERR_C_EXPECTATION	= 417, // Expectation failed
		
		/**
		 * HTTP response codes (Server error) 
		 */
		ERR_S_INTERNAL		= 500, // Internal server error
		ERR_S_UNIMPLEMENTED	= 501, // Not implemented
		ERR_S_GATEWAY		= 502, // Bad gateway
		ERR_S_UNAVAILABLE	= 503, // Service unavailable
		ERR_S_TIMEOUT		= 504, // Server timeout
		ERR_S_VERSION		= 505; // HTTP version not supported
}
