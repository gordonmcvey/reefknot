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
 * This class tests if the provided data is of a numeric type, in other words 
 * an integer or a float. Generally you'll want to be more exact regarding the
 * type you want (integer or float), but there are cases where a programmer
 * will want a number but won't be too concerned whether the number is an 
 * integer or a float. 
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package gordian\reefknot\input\validate\type
 */
class IsNumber extends IsScalar implements iface\Type
{
	/**
	 * Determine if the provided value is a number
	 * 
	 * Implementation note: Whilst the IsNumber class descends from the IsScalar 
	 * class (because a valid number is also implicitly a valid scalar), the 
	 * parent method is not invoked simply for performance reasons.  If the
	 * data passes this check then it would, by definition, have passed the 
	 * superclass check.  The opposite is also true.  All ints and floats are 
	 * scalars, and anything that isn't a scalar can't be an int or a float. 
	 * 
	 * @return bool True if the given data is numeric 
	 */
	public function isValid ()
	{
		$data	= $this -> getData ();
		return ((is_null ($data))
			|| (is_numeric ($data)));
	}
}
