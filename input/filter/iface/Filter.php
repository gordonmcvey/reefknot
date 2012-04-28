<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\filter\iface;

/**
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Input
 * @subpackage Filtering
 * @subpackage Interfaces
 */
interface Filter
{
	public function setData ($data);
	public function setConfig (array $config);
	public function getConfig ();
	public function filter ();
}
