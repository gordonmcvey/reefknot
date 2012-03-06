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
 * Description of Subset
 *
 * @author gordonmcvey
 */
class Subset extends abstr\Prop implements iface\Prop
{
	public function setConfig (array $config = array ())
	{
		if ((isset ($config ['set']))
		&& (is_array ($config ['set']))
		&& (!empty ($config ['set'])))
		{
			return (parent::setConfig ($config));
		}
		else
		{
			throw new \InvalidArgumentException ('Set must be an array');
		}
	}
	
	/**
	 * Test that the given data array is a subset of the Property's set
	 * 
	 * This validator checks that all the elements in the given array are in 
	 * the set that the Property was configured with.  If the array under test
	 * contains only values that are also in the Property's set then the data
	 * is considered to be valid.  If the data array contains any values that
	 * are not in the configured set then the data is considered invalid. 
	 * 
	 * Key values are not taken into consideration during the validation.  
	 * 
	 * @return bool
	 * @throws \InvalidArgumentException 
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
			case 'array'	:
				$cfg	= $this -> getConfig ();
				$diffs	= array_diff ($data, $cfg ['set']);
				$valid	= empty ($diffs);
			break;
			default			: 
				throw new \InvalidArgumentException ('Data must be an array');
			break;
		}
		return ($valid);
	}
}
