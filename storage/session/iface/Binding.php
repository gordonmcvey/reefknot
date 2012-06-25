<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\storage\session\iface;

/**
 * Interface for ReefKnot session binding
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Storage
 * @subpackage Session
 * @subpackage Interfaces
 */
interface Binding
{
	/**
	 * Get the PHP session ID
	 * 
	 * @return string 
	 */
	public function sessionId ();
	
	/**
	 * Test if headers have been sent yet
	 * 
	 * @return bool 
	 */
	public function headersSent ();
	
	/**
	 * Start the PHP session
	 * 
	 * @return bool True if the session started successfully
	 */
	public function startSession ();
	
	/**
	 * Get the specified namespace (subarray) within the PHP session
	 * 
	 * @param scalar $namespace
	 * @return array 
	 */
	public function &getNamespace ($namespace);
}
