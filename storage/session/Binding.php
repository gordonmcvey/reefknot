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
