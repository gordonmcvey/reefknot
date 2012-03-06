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
 * Number data type validation
 * 
 * This class tests if the provided data is of a scalar type.  Any non-composite
 * datatypes (anything that isn't an object, a resource or an array) is a valid
 * scalar
 *
 * @author gordonmcvey
 */
class IsNumber extends IsScalar implements iface\Type
{
	/**
	 * Determine if the provided value is a scalar
	 * 
	 * Whilst the IsNumber class descends from the IsScalar class (because a 
	 * valid number is also implicitly a valid scalar), the parent method is 
	 * not invoked simply for performance reasons.  
	 * 
	 * @return bool True if valid 
	 */
	public function isValid ()
	{
		$data	= $this -> getData ();
		return ((is_null ($data))
			|| (is_numeric ($data)));
	}
}
