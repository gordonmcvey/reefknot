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
 * String data type validator
 * 
 * This datatype validates that its input data is a valid string.  As strings 
 * are also implicitly scalars, this class is a subclass of the IsScalar class.
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package gordian\reefknot\input\validate\type
 */
class IsString extends IsScalar implements iface\Type
{
	/**
	 * Test whether the item's data is a valid string
	 * 
	 * This method tests whether the data the class has been assigned is a 
	 * string.  Like most other Type objects, it will also return true if no
	 * data has been assigned to the object. 
	 * 
	 * Whilst strings are implicitly scalars, this method doesn't use the 
	 * isValid () method in the superclass for performance reasons. 
	 * 
	 * @return bool True if the object's assigned data is a valid string
	 */
	public function isValid ()
	{
		$data	= $this -> getData ();
		return ((is_null ($data))
			|| (is_string ($data)));
	}
}
