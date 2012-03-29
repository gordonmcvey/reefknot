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
 * Type for validating objects
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Type
 */
class IsObject extends abstr\Validatable implements iface\Type
{
	/**
	 * Check that the given data is an object
	 * 
	 * @return bool True if the given data is an object 
	 */
	public function isValid ()
	{
		$data	= $this -> getData ();
		return ((is_null ($data))
			|| (is_object ($data)));
	}
}
