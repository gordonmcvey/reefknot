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
}
