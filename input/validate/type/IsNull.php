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
 * Type for validating NULL
 * 
 * This Type is included simply for completeness. I personally can't think of a 
 * legitimate use for it. If you can then please let me know. ;)
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Type
 */
class IsNull extends abstr\Validatable implements iface\Type
{
	/**
	 * Check that the given data is NULL
	 * 
	 * @return bool True of the data is NULL 
	 */
	public function isValid ()
	{
		return (is_null ($this -> getData ()));
	}
}
