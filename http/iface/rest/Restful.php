<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\http\iface\rest;

use \gordian\reefknot\http\iface;

/**
 * REST object interface
 * 
 * This interface marks a class as being able to respond to REST HTTP requests.
 * 
 * NOTE: This interface should be considered an "abstract interface".  Classes
 * should not implement it directly, they should implement its sub-interfaces 
 * for the HTTP methods that you want your class to respond to. 
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package HTTP
 * @subpackage REST
 * @subpackage Interfaces
 */
interface Restful
{
	/**
	 * Determine if the implementing class supports the given request method
	 * 
	 * Not all HTTP requests are sensible under all contexts for a given 
	 * resource.  For example, your class might not support the PUT, CONNECT or
	 * TRACE method, and only accept POST over a secure connection, or may 
	 * only accept GET requests when the request originates from a given IP
	 * address.  The implementing class should return a boolean value to
	 * indicate whether the given request type is acceptable under the current
	 * conditions.  
	 * 
	 * @bool True if the given HTTP request method can be supported in this case.  
	 */
	public function supportsMethod (iface\Request $request);
}
