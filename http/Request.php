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
		$requestBody		= NULL,
		
		/**
		 * @var array
		 */
		$parsedUri			= array (), 
		
		/**
		 * @var array 
		 */
		$get				= array (),
		
		/**
		 * @var array 
		 */
		$post				= array (),
		
		/**
		 * @var array 
		 */
		$cookie				= array (),
		
		/**
		 * @var array 
		 */
		$files				= array (),
		
		/**
		 * @var array 
		 */
		$server				= array (),
		
		/**
		 * @var array 
		 */
		$env				= array (),
		
		/**
		 * Cache for the parsed headers
		 * 
		 * @var array
		 */
		$parsedHeaders		= array (),
		
		/**
		 * List of valid HTTP verbs
		 * 
		 * @var array 
		 */
		$validMethods		= array (
			self::M_CONNECT,
			self::M_DELETE,
			self::M_GET,
			self::M_HEAD,
			self::M_OPTIONS,
			self::M_POST,
			self::M_POT,
			self::M_TRACE
		), 
		
		/**
		 * When extracting the header data from $_SERVER we want to get these 
		 * keya in addition to the ones that start HTTP_ OR CONTENT-
		 * 
		 * @var array
		 */
		$nonPrefixedHeaders	= array ();

	/**
	 * 
	 * @param string $source Name of the property to get an array from
	 * @param scalar $param
	 * @return mixed
	 */
	protected function getParam ($source, $param = NULL)
	{
		$ret	= NULL;
		
		if (is_scalar ($param))
		{
			// Return the specified key
			$ret	= array_key_exists ($param, $this -> $source)?
				$this -> $source [$param]:
				NULL;
		}
		else
		{
			// No valid key
			throw new \InvalidArgumentException (__METHOD__);
		}
		
		return $ret;
	}
	
	/**
	 * Get a parsed version of the URI that this request embodies 
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
	 * Normalize the header string key
	 * 
	 * We use a couple of different methods for extracting the headers, but they
	 * all return the header data with keys formatted in somewhat different 
	 * styles.  This method attempts to put the header keys into a uniforma 
	 * format, regardless of where they came from. 
	 * 
	 * @param string $header
	 * @return string
	 */
	protected function normalizeHeaderKey ($header)
	{
		// Strip the HTTP_ that PHP prepends to headers in $_SERVER
		if (0 === strpos ($header, 'HTTP_'))
		{
			$header	= substr ($header, 5);
		}
		
		// Get the header key string into a uniform format
		$header	= str_replace (' ', '-', ucwords (strtolower (str_replace (array ('-', '_'), ' ', $header))));
		
		return $header;
	}
	
	/**
	 * Attempt to extract the header data natively
	 * 
	 * If the getallheaders () function is available then using that is the best
	 * way to get at the header data.  It's only available under Apache and 
	 * (as of PHP 5.4) fastCGI, however.  Under other condutions the function
	 * is unavailable and we'll have to use other methods to get the headers
	 * 
	 * @return array
	 */
	protected function getHeadersNatively ()
	{
		return function_exists ('getallheaders')? 
			getallheaders (): 
			array ();
	}
	
	/**
	 * Attempt to extract the header data from the $server data
	 * 
	 * PHP stores a lot of information culled from the headers in $_SERVER.  
	 * This method attempts to extract it.  
	 * 
	 * @return array
	 */
	protected function getHeadersFromServer ()
	{
		$headers	= array ();
		
		foreach ($this -> server as $key => $val)
		{
			// Extract any values from $server that meet the criteria for being from the HTTP headers
			if ((0 === strpos ($key, 'HTTP_'))
			|| (0 === strpos ($key, 'CONTENT-'))
			|| (in_array ($key, $this -> nonPrefixedHeaders)))
			{
				$headers [$key]	= $val;
			}
		}
		
		return $headers;
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
	 * @return boolean True if CONNECT request
	 */
	public function isConnect ()
	{
		return ($this -> getMethod () === static::M_CONNECT);
	}
	
	/**
	 * Determine if this is a HTTP DELETE request
	 * 
	 * @return boolean True if DELETE request
	 */
	public function isDelete ()
	{
		return ($this -> getMethod () === static::M_DELETE);
	}
	
	/**
	 * Determine if this is a HTTP GET request
	 * 
	 * @return boolean True if GET request
	 */
	public function isGet ()
	{
		return ($this -> getMethod () === static::M_GET);
	}
	
	/**
	 * Determine if this is a HTTP HEAD request
	 * 
	 * @return boolean True if HEAD request
	 */
	public function isHead ()
	{
		return ($this -> getMethod () === static::M_HEAD);
	}
	
	/**
	 * Determine if this is a HTTP OPTIONS request
	 * 
	 * @return boolean True if OPTIONS request
	 */
	public function isOptions ()
	{
		return ($this -> getMethod () === static::M_HEAD);
	}
	
	/**
	 * Determine if this is a HTTP POST request
	 * 
	 * @return boolean True if POST request
	 */
	public function isPost ()
	{
		return ($this -> getMethod () === static::M_POST);
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
	 * Get the full set of query (get) parameters
	 * 
	 * @return array
	 */
	public function getQuery ()
	{
		return $this -> get;
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
	public function getQueryParam ($param)
	{
		return $this -> getParam ('get', $param);
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getPost ()
	{
		return $this -> post;
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
	public function getPostParam ($param)
	{
		return $this -> getParam ('post', $param);
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getCookie ()
	{
		return $this -> cookie;
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
	public function getCookieParam ($param = NULL)
	{
		return $this -> getParam ('cookie', $param);
	}
	
	
	/**
	 * Get all the headers
	 * 
	 * @return array
	 */
	public function getHeaders ()
	{
		if (empty ($this -> parsedHeaders))
		{
			// Attempt to get the header data
			if (($headers = $this -> getHeadersNatively ())
			|| ($headers = $this -> getHeadersFromServer ()))
			{
				// Normalize the header keys
				$headerKeys	= array_map (array ($this, 'normalizeHeaderKey'), array_keys ($headers));
				$headers	= array_combine ($headerKeys, $headers);
				
				$this -> parsedHeaders	= $headers;
			}
		}
		
		return $this -> parsedHeaders;
	}
	
	/**
	 * Get the specified header
	 * 
	 * @param strint $key
	 * @return mixed
	 */
	public function getHeaderParam ($key)
	{
		$this -> getHeaders ();
		return $this -> getParam ('parsedHeaders', $key);
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
	 */
	public function IsXhr ()
	{
		return 'XmlHttpRequest' === $this -> getHeaderParam ('X-Requested-With')
			|| (($tmp = $this -> getPostParam ('__reefknot')) && (!empty ($tmp ['xhr'])))
			|| (($tmp = $this -> getQueryParam ('__reefknot')) && (!empty ($tmp ['xhr'])));
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
