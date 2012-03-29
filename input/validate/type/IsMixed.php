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
 * Type for validating Mixed types
 * 
 * Note: This Type is intended for cases where you can accept any type of data
 * as being valid for a given field.  For this reason you should almost never
 * use this type for actual validation.  You will almost always need to know
 * what type the data you're processing is.  This Type exists purely for the 
 * rare cases when you don't know what type you will be processing.  You really
 * shouldn't be using it at all, if you ar ethen that's probably a indication 
 * that you need to rethink your validation strategy. 
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Type
 */
class IsMixed extends abstr\Validatable implements iface\Type
{
	/**
	 * Check that the given data is a Mixed datatype
	 * 
	 * Everything in PHP is a mixed datatype, so this method always returns true
	 * @return bool Always true 
	 */
	public function isValid ()
	{
		return (true);
	}
}
