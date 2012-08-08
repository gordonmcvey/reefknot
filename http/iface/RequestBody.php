<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\http\iface;

/**
 * @author Gordon McVey
 * @category Reefknot
 * @package HTTP
 * @subpackage Request
 * @subpackage Interfaces
 */
interface RequestBody
{
	public function getData ();
	public function saveData ($filename);
	public function getAsParams ();
	public function getParam ($key);
}
