<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\access\iface;

/**
 * Access Control Consumer interface
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Access
 * @subpackage Interfaces
 */
interface Consumer
{
	/**
	 * Get the ID of the item that wishes to access a resource
	 * 
	 * @return int 
	 */
	public function getId ();
}
