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
	/**#@+
 	 * HTTP version strings
	 */
	const	HTTP_VER_10			= 'HTTP/1.0';
	const	HTTP_VER_11			= 'HTTP/1.1';
	/**#@-*/

	/**#@+
 	 * HTTP response codes (1XX, Informational)
	 */

	/**
	 * Continue
	 */
	const	INF_CONTINUE		= 100;

	/**
	 * Switching protocols
	 */
	const	INF_SWITCHING		= 101;
	/**#@-*/

	/**#@+
	 * HTTP response codes (2XX, Successful response)
	 */

	/**
	 * OK
	 */
	const	SUC_OK				= 200;

	/**
	 * Created
	 *
	 * The operation succeeded and resulted in a new resource instance being
	 * created at the URL specified in the Location header
	 */
	const	SUC_CREATED			= 201;

	/**
	 * Accepted
	 *
	 * The requested operation was accepted as valid but may not yet have been
	 * processed.  It may be deferred for processing at a later date
	 */
	const	SUC_ACCEPTED		= 202;

	/**
	 * Non-Authoritative information
	 */
	const	SUC_NON_AUTH		= 203;

	/**
	 * No content
	 *
	 * The request was successful, but there is no response body.
	 */
	const	SUC_NO_CONTENT		= 204;

	/**
	 * Reset content
	 */
	const	SUC_RESET_CONTENT	= 205;

	/**
	 * Partial content
	 *
	 * The request was successful, and a fragment of the full response will be
	 * returned in the request body.
	 */
	const	SUC_PARTIAL			= 206;
	/**#@-*/

	/**#@+
	 * HTTP response codes (3XX, Redirection)
	 */

	/**
	 * Multiple choice
	 */
	const	RDR_MULTIPLE		= 300;

	/**
	 * Permanent redirect
	 *
	 * The requested resource has been moved from the URL used to make the
	 * request to the URL specified in the Location header
	 */
	const	RDR_PERMANENT		= 301;

	/**
	 * Found (used to be Temporary redirect)
	 */
	const	RDR_FOUND			= 302;

	/**
	 * See other
	 */
	const	RDR_SEEOTHER		= 303;

	/**
	 * Not modified
	 *
	 * A resource that the client previously requested has not been changed
	 * since that request was made.  This code notifies the client to use its
	 * cached copy of the resource instead of re-fetching another copy
	 */
	const	RDR_NOTMODDED		= 304;

	/**
	 * Use proxy
	 */
	const	RDR_PROXY			= 305;

	/**
	 * Unused code reserved for future use
	 */
	const	RDR_RESERVED		= 306;

	/**
	 * Temporary redirect
	 *
	 * This code informs the client that the resource requested currently isn't
	 * available under the current URL and should instead use the URL provided
	 * in the Location header.  However, this is not a permanent state of
	 * affairs and the URL is expected to revert to its own value in the future.
	 */
	const	RDR_TEMPORARY		= 307;
	/**#@-*/

	/**#@+
	 * HTTP response codes (Client error)
	 */

	/**
	 * Bad request
	 */
	const	ERR_C_BADREQ		= 400;

	/**
	 * Unauthorized
	 */
	const	ERR_C_UNAUTHED		= 401;

	/**
	 * Payment required
	 */
	const	ERR_C_PAYREQ		= 402;

	/**
	 * Forbidden
	 *
	 * The client is forbidden from accessing the requested resource
	 */
	const	ERR_C_FORBIDDEN		= 403;

	/**
	 * Not found
	 *
	 * The requested resource doesn't exist.
	 */
	const	ERR_C_NOTFOUND		= 404;

	/**
	 * Method not allowed
	 */
	const	ERR_C_METHOD		= 405;

	/**
	 * Not acceptable
	 */
	const	ERR_C_UNACCEPTABLE	= 406;

	/**
	 * Proxy authentication required
	 */
	const	ERR_C_AUTH_PROXY	= 407;

	/**
	 * Request timeout
	 */
	const	ERR_C_TIMEOUT		= 408;

	/**
	 * Conflict
	 */
	const	ERR_C_CONFLICT		= 409;

	/**
	 * Gone
	 *
	 * This alerts the client that the request URL once referred to an
	 * accessible resource but that this is no longer the case.  This is
	 * distinct from 404 Not Found in that a 404 error occurs for any resource
	 * that doesn't exist on the server including ones that never existed.
	 * This code indicates that a resource once existed at the given URL but has
	 * since been removed.
	 */
	const	ERR_C_GONE			= 410;

	/**
	 * Length required
	 */
	const	ERR_C_NOLENGTH		= 411;

	/**
	 * Precondition failed
	 */
	const	ERR_C_PRECONDITION	= 412;

	/**
	 * Request entity too large
	 */
	const	ERR_C_TOOLARGE		= 413;

	/**
	 * Request URI too long
	 */
	const	ERR_C_URILONG		= 414;

	/**
	 * Upsupported media type
	 */
	const	ERR_C_MEDIATYPE		= 415;

	/**
	 * Requested range not satisfiable
	 */
	const	ERR_C_RANGE			= 416;

	/**
	 * Expectation failed
	 */
	const	ERR_C_EXPECTATION	= 417;
	/**#@-*/

	/**#@+
	 * HTTP response codes (Server error)
	 */

	/**
	 * Internal server error
	 *
	 * The web server was mis-configured, or the application has failed in  some
	 * way that has nothing to do with the request the client was trying to make
	 */
	const	ERR_S_INTERNAL		= 500;

	/**
	 * Not implemented
	 */
	const	ERR_S_UNIMPLEMENTED	= 501;

	/**
	 * Bad gateway
	 */
	const	ERR_S_GATEWAY		= 502;

	/**
	 * Service unavailable
	 */
	const	ERR_S_UNAVAILABLE	= 503;

	/**
	 * Server timeout
	 */
	const	ERR_S_TIMEOUT		= 504;

	/**
	 * HTTP version not supported
	 */
	const	ERR_S_VERSION		= 505;
	/**#@-*/

	public function setStatus ($status);
	public function getStatus ();
	public function getStatusMessage ();
	public function getStatusHeader ();
	public function setHeader ($key, $value);
	public function setBody ($body);
	public function send ();
}
