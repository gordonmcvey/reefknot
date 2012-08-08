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
	 * Get the specified namespace (subarray) within the PHP session
	 * 
	 * @param scalar $namespace
	 * @return array 
	 */
	public function &getNamespace ($namespace);
}
