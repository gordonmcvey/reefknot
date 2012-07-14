<?php

/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\http;

/**
 * HTTP Request interogation class
 * 
 * This class implements methods for extracting information from a HTTP request.
 * 
 * A request consists of the following components:
 * 
 * * An access method (also known as a HTTP verb).  GET, POST, PUT, DELETE, etc
 * * A URI which uniquely identifies a resource to apply the request to 
 * * A set of request headers
 * * A query string
 * * An entity body
 * * * For POST requests this contains the data from the posted form
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package HTTP
 */
class Request implements iface\Request
{
	protected
		
		/**
		 * @var iface\util\RequestBody 
		 */
		$requestBody	= NULL,
		
		/**
		 * @var iface\util\Bucket 
		 */
		$get			= array (),
		
		/**
		 * @var iface\util\Bucket 
		 */
		$post			= array (),
		
		/**
		 * @var iface\util\Bucket 
		 */
		$cookie			= array (),
		
		/**
		 * @var iface\util\Bucket 
		 */
		$files			= array (),
		
		/**
		 * @var iface\util\Bucket 
		 */
		$server			= array (),
		
		/**
		 * @var iface\util\Bucket 
		 */
		$env			= array (),
		
		/**
		 * List of valid HTTP verbs
		 * 
		 * @var array 
		 */
		$validMethods	= array (
			self::M_CONNECT,
			self::M_DELETE,
			self::M_GET,
			self::M_HEAD,
			self::M_OPTIONS,
			self::M_POST,
			self::M_POT,
			self::M_TRACE
		);

	/**
	* Determine if the function argument is a valid HTTP method/verb
	* 
	* @param string $method
	* @return bool 
	*/
	public function methodValid ($method)
	{
		return in_array ($method, $this -> validMethods);
	}
	
	/**
	 * Get the Request method
	 * 
	 * This method returns a string containing the HTTP request method verb, or
	 * NULL if the request verb isn't valid/is unknown. 
	 * 
	 * @return string 
	 */
	public function getMethod ()
	{
		return ($this -> methodValid ($this -> server ['REQUEST_METHOD'])?
				$this -> server ['REQUEST_METHOD']:
				NULL);
	}
	
	/**
	 * Determine if this is a HTTP CONNECT request
	 * 
	 * @return bool 
	 */
	public function isConnect ()
	{
		return ($this -> getMethod () === self::M_CONNECT);
	}
	
	/**
	 * Determine if this is a HTTP DELETE request
	 * 
	 * @return bool 
	 */
	public function isDelete ()
	{
		return ($this -> getMethod () === self::M_DELETE);
	}
	
	/**
	 * Determine if this is a HTTP GET request
	 * 
	 * @return bool 
	 */
	public function isGet ()
	{
		return ($this -> getMethod () === self::M_GET);
	}
	
	/**
	 * Determine if this is a HTTP HEAD request
	 * 
	 * @return bool 
	 */
	public function isHead ()
	{
		return ($this -> getMethod () === self::M_HEAD);
	}
	
	/**
	 * Determine if this is a HTTP OPTIONS request
	 * 
	 * @return bool 
	 */
	public function isOptions ()
	{
		return ($this -> getMethod () === self::M_HEAD);
	}
	
	/**
	 * Determine if this is a HTTP POST request
	 * 
	 * @return bool 
	 */
	public function isPost ()
	{
		return ($this -> getMethod () === self::M_POST);
	}
	
	/**
	 * Determine if this is a HTTP PUT request
	 * 
	 * @return boolean True if this is a PUT request
	 */
	public function isPut ()
	{
		return $this -> getMethod () === static::M_POT;
	}
	
	/**
	 * Determine if this is a HTTP TRACE request
	 * 
	 * @return boolean True if this is a TRACE request
	 */
	public function isTrace ()
	{
		return $this -> getMethod () === static::M_TRACE;
	}
	
	/**
	 * Determine whether the request as made over a secure channel.  
	 * 
	 * This method checks for the presence of the HTTPS server variable.  Apache
	 * only sets the variable for HTTPS requests, but IIS always sets it, but 
	 * with the value of "off" for non-HTTPS requests.  
	 * 
	 * @return boolean True if the connection was made over HTTPS
	 */
	public function isSecure ()
	{
		return (!empty ($this -> server ['HTTPS']))
			&& ($this -> server ['HTTPS'] !== 'off');
	}
	
	/**
	 * Determine whether the current request was made with an XmlHttpRequest javascript object
	 * 
	 * The rules that this method follows to determine if this request is being
	 * made with XmlHttpRequest are as follows: 
	 * 
	 * 1) Check for a header called X-REQUESTED-WITH.  If it exists and is set
	 * to a value of 'XmlHttpRequest' then return true (jQuery and several
	 * other javascript libraries set this header when making an AJAX request
	 * and you can set it manually if doing AJAX with raw javascript)
	 * 
	 * 2) If this request is a POST request then look for an attribute called 
	 * 'reefknot' ['xhr'] in the POSTed data.  If it exists and is set to a 
	 * non-empty value, then return true.  (This can be done by putting a 
	 * hidden input field in your form called 'reefknot[xhr]' with a non-empty
	 * value in your form)
	 * 
	 * 3) If this request isn't a POST request then look for an attribute called
	 * 'reefknot ['xhr']' in the query string.  If it exists and is set to a 
	 * non-empty value, then return true.  (This can be done with a hidden form
	 * element in GET method forms as with POSTed forms, or you could simply 
	 * append ?reefknot[xhr]=1 onto the URL you're requesting the resource with)
	 * 
	 * If none of the above criteria are met, then return false.  
	 * 
	 * @return boolean True if the request appears to have been made with an XHR object
	 * @todo This method needs to be properly implemented. It currently only always returns false
	 */
	public function IsXhr ()
	{
		return false;
	}
	
	/**
	 * Request constructor
	 * 
	 * @param iface\util\RequestBody $reqBody
	 * @param array $get Where the $_GET data will come from
	 * @param array $post Where the $_POST data will come from
	 * @param array $cookie Where the $_COOKIE data will come from
	 * @param array $files Where the $_FILES data will come from
	 * @param array $server Where the $_SERVER data will come from
	 * @param array $env Where the $_ENV data will come crom
	 */
	public function __construct (	iface\util\RequestBody $reqBody,
									array $get,
									array $post,
									array $cookie,
									array $files,
									array $server,
									array $env)
	{
		// Get all the request data.  
		$this -> requestBody	= $reqBody;
		$this -> get			= $get;
		$this -> post			= $post;
		$this -> cookie			= $cookie;
		$this -> files			= $files;
		$this -> server			= $server;
		$this -> env			= $env;
	}
}
