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
 * @author gordonmcvey
 */
class Request implements iface\Request
{
	protected
		
		/**
		 * @var iface\util\RequestBody 
		 */
		$requestBody	= NULL,
		
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
	* Determine if the function argument is a valid HTTP method/verb
	* 
	* @param string $method
	* @return bool 
	*/
	public function methodValid ($method)
	{
		return (in_array ($method, $this -> validMethods));
	}

	public function __construct (	iface\util\RequestBody $reqBody,
									array $get		= NULL,
									array $post		= NULL,
									array $cookie	= NULL,
									array $files	= NULL,
									array $server	= NULL, 
									array $env		= NULL)
	{
		// Get all the request data.  
		$this -> requestBody	= $reqBody;
		
		if ($get === NULL)
			$this -> get	= $_GET;	
		else	
			$this -> get	= $get;
		
		if ($post === NULL)
			$this -> post	= $_POST;
		else
			$this -> post	= $post;
		
		if ($cookie === NULL)
			$this -> cookie	= $_COOKIE;
		else
			$this -> cookie	= $cookie;
		
		if ($files === NULL)
			$this -> files	= $_FILES;	
		else
			$this -> files	= $files;
		
		if ($server === NULL)
			$this -> server	= $_SERVER;
		else
			$this -> server	= $server;
		
		if ($env === NULL)
			$this -> env	= $_ENV;
		else
			$this -> env	= $env;
	}
}
