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
 * Type for validating integers
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Type
 */
class IsInt extends IsNumber implements iface\Type
{
	/**
	 * Check that the provided data is an integer
	 * 
	 * @return bool True if the provided data is an integer 
	 */
	public function isValid ()
	{
		$data	= $this -> getData ();
		return ((is_null ($data))
			|| (is_int ($data)));
	}
}
