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
interface Uri
{
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
	 * Get the hostname refered to in URI
	 * 
	 * @return string
	 */
	public function getHost ();
	
	/**
	 * Get the password encoded in the URI
	 * 
	 * @return string
	 */
	public function getPassword ();
	
	/**
	 * Get the password encoded in the URI
	 * 
	 * @return string
	 */
	public function getRawPassword ();
	
	/**
	 * Get the path referenced by the URI
	 * 
	 * @return string
	 */
	public function getPath ();
	
	/**
	 * Get the port this request was made over 
	 * 
	 * @return int
	 */
	public function getPort ();
	
	/**
	 * Get the query as an unparsed string
	 * 
	 * @return string
	 */
	public function getQueryString ();
	
	/**
	 * Get the scheme used for this request (http, ftp, etc)
	 * 
	 * @return string
	 */
	public function getScheme ();
	
	/**
	 * Get the URI as a string
	 */
	public function getUri ();
	
	/**
	 * Get the username encoded in the URI
	 * 
	 * @return string
	 */
	public function getUser ();

	/**
	 * Set the URI scheme
	 * 
	 * @param string $scheme
	 * @return MutableUri
	 */
	public function setScheme ($scheme);
	
	/**
	 * Set the hostname
	 * 
	 * @param string $host
	 * @return MutableUri
	 */
	public function setHost ($host);
	
	/**
	 * Set the port
	 * 
	 * @param int $port
	 * @return MutableUri
	 */
	public function setPort ($port);
	
	/**
	 * Set the password
	 * 
	 * @param string $password
	 * @return MutableUri
	 */
	public function setPassword ($password);
	
	/**
	 * Set the path
	 * 
	 * @param string $path
	 * @return MutableUri
	 */
	public function setPath ($path);
	
	/**
	 * Set the query
	 * 
	 * @param string|array $query
	 * @return MutableUri
	 */
	public function setQuery ($query);
	
	/**
	 * Set the fragment
	 * 
	 * @param type $fragment
	 * @return MutableUri
  	 */
	public function setFragment	($fragment);
	
	/**
	 * Instantiate a URI object
	 * 
	 * @param string|array $uri
	 */
	public function __construct ($uri);
	
	/**
	 * Return the URI as a string
	 * 
	 * @return string
	 */
	public function __toString ();
}
