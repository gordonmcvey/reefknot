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
 * Regular expression matching property
 * 
 * This property can be used to test that a string matches a provided regular
 * expression.  It can only be used with strings. 
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Prop
 */
class RegexMatch extends abstr\prop\TextMatch implements iface\Prop
{
	/**
	 * Test that the given data matches the specified regular expression. 
	 * 
	 * @return bool True if the data matches
	 * @throws \InvalidArgumentException Triggered on an attempt to use this validator on non-string data
	 */
	public function isValid ()
	{
		$valid	= false;
		$data	= $this -> getData ();
		
		switch (gettype ($data))
		{
			case 'NULL'		:
				$valid	= true;
			break;
			case 'string'	:
				$cfg	= $this -> getConfig ();
				$valid	= preg_match ($cfg ['needle'], $data) > 0;
			break;
			default			:
				throw new \InvalidArgumentException (__CLASS__ . ': This property cannot be applied to data of type ' . gettype ($data));
			break;
		}
		
		return ($valid);
	}
}
