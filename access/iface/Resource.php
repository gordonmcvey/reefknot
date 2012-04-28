<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\access\iface;

/**
 * Access Control Resource interface
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Access
 * @subpackage Interfaces
 */
interface Resource
{
	/**
	 * Get the ID of the access-controlled resource
	 * 
	 * @return int 
	 */
	public function getId ();
}
