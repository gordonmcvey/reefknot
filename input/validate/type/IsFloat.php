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
 * Type for validating floating point data
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package gordian\reefknot\input\validate\type
 */
class IsFloat extends IsNumber implements iface\Type
{
	
	/**
	 * Validate that the given data is a floating point number
	 * 
	 * @return bool True of the data is floating point 
	 */
	public function isValid ()
	{
		$data	= $this -> getData ();
		return ((is_null ($data))
			|| (is_float ($data)));
	}
}
