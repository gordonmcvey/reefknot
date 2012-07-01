<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\storage\session;

/**
 * Session binding
 * 
 * This class serves as a binding between the Session class and the underlying 
 * PHP $_SESSION mechanism.  The reason that this class exists is so that the
 * Session class can be decoupled from the global state represented by the 
 * $_SESSION superglobal.  Amongst other things, this allows for much simpler
 * testing of the Session class, as we can mock this class for testing.  
 * 
 * Normally, you would never use this class directly in your code, you'd just
 * pass an instance of it to new instances of the Session class.  
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Storage
 * @subpackage Session
 */
class Binding implements iface\Binding
{
	/**
	 * Get the PHP session ID
	 * 
	 * @return string 
	 */
	public function sessionId ()
	{
		return \session_id ();
	}
	
	/**
	 * Test if headers have been sent yet
	 * 
	 * @return bool 
	 */
	public function headersSent ()
	{
		return \headers_sent ();
	}
	
	/**
	 * Start the PHP session
	 * 
	 * @return bool True if the session started successfully
	 */
	public function startSession ()
	{
		return \session_start ();
	}
	
	/**
	 * Get the specified namespace (subarray) within the PHP session
	 * 
	 * @param scalar $namespace
	 * @return array 
	 */
	public function &getNamespace ($namespace)
	{
		return $_SESSION [$namespace];
	}
}
