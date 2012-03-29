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
 * Type for validating scalar data
 * 
 * In PHP a scalar is any non-composite datatype.  This means that ints, floats,
 * strings and booleans are scalar.  Arrays, objects and resources are not 
 * scalar types. 
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Type
 */
class IsScalar extends abstr\Validatable implements iface\Type
{
	/**
	 * Test that the given data is a scalar
	 * 
	 * @return bool True if the given data is a scalar 
	 */
	public function isValid ()
	{
		$data	= $this -> getData ();
		return ((is_null ($data))
			|| (is_scalar ($data)));
	}
}
