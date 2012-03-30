<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\prop;

use
	gordian\reefknot\input\validate\abstr, 
	gordian\reefknot\input\validate\iface;

/**
 * Prop for testing if the given data is in a set
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Prop
 */
class SetMember extends abstr\Prop\Set implements iface\Prop
{
	public function isValid ()
	{
		$cfg	= $this -> getConfig ();
		$data	= $this -> getData ();
		
		return ((is_null ($data))
			|| (in_array ($data, $cfg ['set'], true)));
	}
}
