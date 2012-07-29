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
		 * The request body data is cached here after being retrieved
		 * 
		 * @var string 
		 */
		$requestBody	= NULL,
		
		/**
		 * @var array
		 */
		$parsedUri		= array (), 
		
		/**
		 * @var array 
		 */
		$get			= array (),
		
		/**
		 * @var array 
		 */
		$post			= array (),
		
		/**
		 * @var array 
		 */
		$cookie			= array (),
		
		/**
		 * @var array 
		 */
		$files			= array (),
		
		/**
		 * @var array 
		 */
		$server			= array (),
		
		/**
		 * @var array 
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
	 * 
	 * @param string $source
	 * @param scalar $param
	 * @return mixed
	 */
	protected function getParam ($source, $param = NULL)
	{
		$ret	= NULL;
		
		if (is_scalar ($param))
		{
			// If a particular element in the parameters was specified than return that
			$ret	= array_key_exists ($param, $this -> $source)?
				$this -> $source [$param]:
				NULL;
		}
		else
		{
			// Return all parameters
			$ret	= $this -> $source;
		}
		
		return $ret;
	}
	
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
	 * Get query parameters
	 * 
	 * This method will return the entire contents of the query part of the URI 
	 * (equivilent to $_GET) if no key is specified.  If a key is specified then
	 * this methos will return it's value, or NULL if no value for that key was
	 * specified
	 * 
	 * @param scalar $param
	 * @return mixed
	 */
	public function getQuery ($param = NULL)
	{
		return $this -> getParam ('get', $param);
	}
	
	/**
	 * Get query parameters
	 * 
	 * This method will return the entire contents of the posted request data 
	 * (equivilent to $_POST) if no key is specified.  If a key is specified 
	 * then this methos will return it's value, or NULL if no value for that key 
	 * was specified
	 * 
	 * @param scalar $param
	 * @return mixed
	 */
	public function getPost ($param = NULL)
	{
		return $this -> getParam ('post', $param);
	}
	
	/**
	 * Get query parameters
	 * 
	 * This method will return the entire contents of the cookie associated with
	 * the request (equivilent to $_COOKIE) if no key is specified.  If a key is 
	 * specified then this method will return it's value, or NULL if no value 
	 * for that key was specified
	 * 
	 * @param scalar $param
	 * @return mixed
	 */
	public function getCookie ($param = NULL)
	{
		return $this -> getParam ('cookie', $param);
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
	 * '__reefknot' ['xhr'] in the POSTed data.  If it exists and is set to a 
	 * non-empty value, then return true.  (This can be done by putting a 
	 * hidden input field in your form called 'reefknot[xhr]' with a non-empty
	 * value in your form)
	 * 
	 * 3) If this request isn't a POST request then look for an attribute called
	 * '__reefknot ['xhr']' in the query string.  If it exists and is set to a 
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
	 * Get the request body data
	 * 
	 * @return string
	 */
	public function getRequestBody ()
	{
		if (is_null ($this -> requestBody))
		{
			$this -> requestBody	= file_get_contents ('php://input');
		}
		return $this -> requestBody;
	}
	
	/**
	 * Get the URI for this request
	 * 
	 * @return string
	 */
	public function getUri ()
	{
		return $this -> server ['REQUEST_URI'];
	}
	
	/**
	 * 
	 * @return array
	 */
	protected function getParsedUri ()
	{
		if (empty ($this -> parsedUri))
		{
			$this -> parsedUri	= parse_url ($this -> getUri ());
			$this -> parsedUri ['port']	= array_key_exists ('port', $this -> parsedUri)?
				intval ($this -> parsedUri ['port']):
				80;
		}
		
		return $this -> parsedUri;
	}
	
	/**
	 * Get the fragment (any text that follows a # character) in the URI
	 * 
	 * Note that browsers are not required to send the fragment to the server,
	 * and several don't.  
	 * 
	 * @return string
	 */
	public function getFragment ()
	{
		$parsed	= $this -> getParsedUri ();
		return $parsed ['fragment'];
	}

	/**
	 * Get the specified header
	 * 
	 * @param strint $header
	 * @return mixed
	 */
	public function getHeader ($header)
	{
		
	}

	/**
	 * Get all the headers
	 * 
	 * @return array
	 */
	public function getHeaders ()
	{
		
	}

	/**
	 * Get the hostname refered to in this request
	 * 
	 * @return string
	 */
	public function getHost ()
	{
		$parsed	= $this -> getParsedUri ();
		return $parsed ['host'];
	}

	/**
	 * Get the password encoded in the URI
	 * 
	 * @return string
	 */
	public function getPassword ()
	{
		$parsed	= $this -> getParsedUri ();
		return $parsed ['pass'];
	}

	/**
	 * Get the path referenced by the URI
	 * 
	 * @return string
	 */
	public function getPath ()
	{
		$parsed	= $this -> getParsedUri ();
		return $parsed ['path'];
	}
	
	/**
	 * Get the port this request was made over 
	 * 
	 * @return int
	 */
	public function getPort ()
	{
		$parsed	= $this -> getParsedUri ();
		return $parsed ['fragment'];
	}
	
	/**
	 * Get the scheme used for this request (http, ftp, etc)
	 * 
	 * @return string
	 */
	public function getScheme ()
	{
		$parsed	= $this -> getParsedUri ();
		return $parsed ['scheme'];
	}

	/**
	 * Get the username encoded in the URI
	 * 
	 * @return string
	 */
	public function getUser ()
	{
		$parsed	= $this -> getParsedUri ();
		return $parsed ['user'];
	}
	
	/**
	 * Request constructor
	 * 
	 * @param array $get Where the $_GET data will come from
	 * @param array $post Where the $_POST data will come from
	 * @param array $cookie Where the $_COOKIE data will come from
	 * @param array $files Where the $_FILES data will come from
	 * @param array $server Where the $_SERVER data will come from
	 * @param array $env Where the $_ENV data will come crom
	 */
	public function __construct (	array $get,
									array $post,
									array $cookie,
									array $files,
									array $server,
									array $env)
	{
		// Get all the request data.  
		$this -> get	= $get;
		$this -> post	= $post;
		$this -> cookie	= $cookie;
		$this -> files	= $files;
		$this -> server	= $server;
		$this -> env	= $env;
	}

}
