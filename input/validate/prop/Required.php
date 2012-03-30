<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\prop;

use
	gordian\reefknot\input\validate\abstr, 
	gordian\reefknot\input\validate\iface;

/**
 * Required value validation property
 * 
 * The required property should be added to validation rule sets where a 
 * non-empty value must be supplied for the data to be considered valid. Any
 * value that would be empty according to the PHP empty() function will be 
 * considered to be invalid against this rule.  The Required property is the 
 * exception to the rule that validation rules will pass NULL values as valid.
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Prop
 */
class Required extends abstr\Prop implements iface\Prop
{
	/**
	 * Test that the required data has a value
	 * 
	 * @return bool True if the data has a value
	 */
	public function isValid ()
	{
		$data	= $this -> getData ();
		return ((!is_null ($data))
			&& (!empty ($data)));
	}
}
