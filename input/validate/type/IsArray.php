<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\type;

use 
	gordian\reefknot\input\validate\abstr, 
	gordian\reefknot\input\validate\iface;

/**
 * Check the given data is an array
 * 
 * The IsArray type checks that the provided data is valid as an array
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Type
 */
class IsArray extends abstr\Validatable implements iface\Type
{
	/**
	 * The IsArray validation rule is that the item is valid provided that it 
	 * is an array
	 * 
	 * @return bool True if valid
	 */
	public function isValid ()
	{
		$data	= $this -> getData ();
		return ((is_null ($data))
			|| (is_array ($data)));
	}
}
