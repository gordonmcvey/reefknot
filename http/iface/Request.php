<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\http\iface;

/**
 * HTTP Request object interface
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package HTTP
 * @subpackage Interfaces
 */
interface Request
{
	const
		
		/**#@+
 		 * HTTP verb list 
		 */
		M_CONNECT	= 'CONNECT',
		M_DELETE	= 'DELETE',
		M_GET		= 'GET',
		M_HEAD		= 'HEAD',
		M_OPTIONS	= 'OPTIONS',
		M_POST		= 'POST',
		M_POT		= 'PUT',
		M_TRACE		= 'TRACE';
		/**#@-*/
	
	/**
	 * Return the HTTP verb (method) that applies to this request
	 * 
	 * @return string
	 */
	public function getMethod ();
	
	/**
	 * Return true if this request was made with the CONNECT verb
	 * 
	 * @return boolean True if CONNECT request
	 */
	public function isConnect ();
	
	/**
	 * Return true if this request was made with the DELETE verb
	 * 
	 * @return boolean True if DELETE request
	 */
	public function isDelete ();
	
	/**
	 * Return true if this request was made with the GET verb
	 * 
	 * @return boolean True if GET request
	 */
	public function isGet ();
	
	/**
	 * Return True if this request was made with the HEAD verb
	 * 
	 * @return boolean True if HEAD request
	 */
	public function isHead ();
	
	/**
	 * Return true if this request was made with the OPTIONS verb
	 * 
	 * @return boolean True if OPTIONS request
	 */
	public function isOptions ();
	
	/**
	 * Return true if this request was made with the POST verb
	 * 
	 * @return boolean True if POST request
	 */
	public function isPost ();
	
	/**
	 * Return true if this request was made with the PUT verb
	 * 
	 * @return boolean True if PUT request
	 */
	public function isPut ();
	
	/**
	 * Return true if this request was made with the TRACE verb
	 * 
	 * @return boolean True if TRACE request
	 */
	public function isTrace ();
	
	/**
	 * Return true if this request indicates that it was made using an XMLHttpRequest javascript object
	 * 
	 * @return boolean True if the request appears to have been made with an XHR object
	 */
	public function IsXhr ();
	
	/**
	 * Return true if this request was made over an SSL connection
	 * 
	 * @return boolean True if HTTPS
	 */
	public function isSecure ();
	
	/**
	 * Get the request body data
	 * 
	 * @return string
	 */
	public function getRequestBody ();
	
	/**
	 * Get all the headers
	 * 
	 * @return array
	 */
	public function getHeaders ();
	
	/**
	 * Get the specified header
	 * 
	 * @param strint $header
	 * @return mixed
	 */
	public function getHeader ($header);
	
	/**
	 * Get the URI for this request
	 * 
	 * @return string
	 */
	public function getUri ();
	
	/**
	 * Get the scheme used for this request (http, ftp, etc)
	 * 
	 * @return string
	 */
	public function getScheme ();
	
	/**
	 * Get the hostname refered to in this request
	 * 
	 * @return string
	 */
	public function getHost ();
	
	/**
	 * Get the port this request was made over 
	 * 
	 * @return int
	 */
	public function getPort ();
	
	/**
	 * Get the username encoded in the URI
	 * 
	 * @return string
	 */
	public function getUser ();
	
	/**
	 * Get the password encoded in the URI
	 * 
	 * @return string
	 */
	public function getPassword ();
	
	/**
	 * Get the path referenced by the URI
	 * 
	 * @return string
	 */
	public function getPath ();
	
	/**
	 * Get the fragment (any text that follows a # character) in the URI
	 * 
	 * Note that browsers are not required to send the fragment to the server,
	 * and several don't.  
	 * 
	 * @return string
	 */
	public function getFragment ();
	
	/**
	 * Get parameters from the query string 
	 * 
	 * @param scalar $param
	 * @return mixed
	 */
	public function getQuery ($param);
	
	/**
	 * Get parameters from the POST data
	 * 
	 * @param scalar $param
	 * @return mixed
	 */
	public function getPost ($param);
	
	/**
	 * Get parameters from the request cookie
	 * 
	 * @param scalar $param
	 * @return mixed
	 */
	public function getCookie ($param);
}
