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
 * @author Gordon McVey
 * @category Reefknot
 * @package HTTP
 * @subpackage Interfaces
 */
interface Response
{
	const
		
		/**#@+
 		 * HTTP version strings
		 */
		HTTP_VER_10			= 'HTTP/1.0',
		HTTP_VER_11			= 'HTTP/1.1',
		/**#@-*/
		
		/**#@+
 		 * HTTP response codes (1XX, Informational)
		 */
		
		/**
		 * Continue
		 */
		INF_CONTINUE		= 100,
		
		/**
		 * Switching protocols
		 */
		INF_SWITCHING		= 101,
		/**#@-*/
		
		/**#@+
		 * HTTP response codes (2XX, Successful response) 
		 */
		
		/**
		 * OK
		 */
		SUC_OK				= 200,
		
		/**
		 * Created
		 * 
		 * The operation succeeded and resulted in a new resource instance being
		 * created at the URL specified in the Location header
		 */
		SUC_CREATED			= 201,
		
		/**
		 * Accepted
		 * 
		 * The requested operation was accepted as valid but may not yet have
		 * been processed.  It may be deferred for processing at a later date
		 */
		SUC_ACCEPTED		= 202,
		
		/**
		 * Non-Authoritative information
		 */
		SUC_NON_AUTH		= 203,
		
		/**
		 * No content
		 * 
		 * The request was successful, but there is no response body. 
		 */
		SUC_NO_CONTENT		= 204,
		
		/**
		 * Reset content
		 */
		SUC_RESET_CONTENT	= 205,
		
		/**
		 * Partial content
		 * 
		 * The request was successful, and a fragment of the full response will
		 * be returned in the request body.  
		 */
		SUC_PARTIAL			= 206,
		/**#@-*/
		
		/**#@+
		 * HTTP response codes (3XX, Redirection) 
		 */
		
		/**
		 * Multiple choice
		 */
		RDR_MULTIPLE		= 300,
		
		/**
		 * Permanent redirect
		 * 
		 * The requested resource has been moved from the URL used to make the
		 * request to the URL specified in the Location header
		 */
		RDR_PERMANENT		= 301,
		
		/**
		 * Found (used to be Temporary redirect)
		 */
		RDR_FOUND			= 302,
		
		/**
		 * See other
		 */
		RDR_SEEOTHER		= 303,
		
		/**
		 * Not modified
		 * 
		 * A resource that the client previously requested has not been changed
		 * since that request was made.  This code notifies the client to use
		 * its cached copy of the resource instead of redownloading another copy
		 */
		RDR_NOTMODDED		= 304,
		
		/**
		 * Use proxy
		 */
		RDR_PROXY			= 305,
		
		/**
		 * Unused code reserved for future use
		 */
		RDR_RESERVED		= 306,
		
		/**
		 * Temporary redirect
		 * 
		 * This code informs the client that the resource requested currently 
		 * isn't available under the current URL and should instead use the URL
		 * provided in the Location header.  However, this is not a permanent 
		 * state of affairs and the URL is expected to revert to its own value
		 * in the future. 
		 */
		RDR_TEMPORARY		= 307,
		/**#@-*/
		
		/**#@+
		 * HTTP response codes (Client error) 
		 */
		
		/**
		 * Bad request
		 */
		ERR_C_BADREQ		= 400,
		
		/**
		 * Unauthorized
		 */
		ERR_C_UNAUTHED		= 401,
		
		/**
		 * Payment required
		 */
		ERR_C_PAYREQ		= 402,
		
		/**
		 * Forbidden
		 * 
		 * The client is forbidden from accessing the requested resource
		 */
		ERR_C_FORBIDDEN		= 403,
		
		/**
		 * Not found
		 * 
		 * The requested resource doesn't exist. 
		 */
		ERR_C_NOTFOUND		= 404,
		
		/**
		 * Method not allowed
		 */
		ERR_C_METHOD		= 405,
		
		/**
		 * Not acceptable
		 */
		ERR_C_UNACCEPTABLE	= 406,
		
		/**
		 * Proxy authentication required
		 */
		ERR_C_AUTH_PROXY	= 407,
		
		/**
		 * Request timeout
		 */
		ERR_C_TIMEOUT		= 408,
		
		/**
		 * Conflict
		 */
		ERR_C_CONFLICT		= 409,
		
		/**
		 * Gone
		 * 
		 * This alerts the client that the request URL used to refer to an 
		 * accessable resource but that this is no longer the case.  This is 
		 * distinct from 404 Not Found in that a 404 error occurs for any URL
		 * that doesn't point to a valid resource and doesn't carry any extra
		 * information about whether the URL used to be valid. 
		 */
		ERR_C_GONE			= 410,
		
		/**
		 * Length required
		 */
		ERR_C_NOLENGTH		= 411,
		
		/**
		 * Precondition failed
		 */
		ERR_C_PRECONDITION	= 412,
		
		/**
		 * Request entity too large
		 */
		ERR_C_TOOLARGE		= 413,
		
		/**
		 * Request URI too long
		 */
		ERR_C_URILONG		= 414,
		
		/**
		 * Upsupported media type
		 */
		ERR_C_MEDIATYPE		= 415,
		
		/**
		 * Requested range not satisfiable
		 */
		ERR_C_RANGE			= 416,
		
		/**
		 * Expectation failed
		 */
		ERR_C_EXPECTATION	= 417,
		/**#@-*/
		
		/**#@+
		 * HTTP response codes (Server error) 
		 */
		
		/**
		 * Internal server error
		 * 
		 * The web server was misconfigured, or the application has failed in 
		 * some way that has nothing to do with the request the client was 
		 * trying to make.
		 */
		ERR_S_INTERNAL		= 500,
		
		/**
		 * Not implemented
		 */
		ERR_S_UNIMPLEMENTED	= 501,
		
		/**
		 * Bad gateway
		 */
		ERR_S_GATEWAY		= 502,
		
		/**
		 * Service unavailable
		 */
		ERR_S_UNAVAILABLE	= 503,
		
		/**
		 * Server timeout
		 */
		ERR_S_TIMEOUT		= 504,
		
		/**
		 * HTTP version not supported
		 */
		ERR_S_VERSION		= 505;
		/**#@-*/
	
	public function setStatus ();
	public function getStatus ();
	public function getStatusMessage ();
	public function getStatusHeader ();
	public function setHeader ($key, $value);
	public function setBody ($body);
	public function send ();
}
