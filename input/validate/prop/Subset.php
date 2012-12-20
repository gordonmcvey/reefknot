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
 * Prop for validating that one array is a subset of the other
 * 
 * This prop is intended for comparing arrays.  For checking that a scalar type
 * is in an array, use SetMember instead. 
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Prop
 */
class Subset extends abstr\Prop\Set implements iface\Prop
{
	
	/**
	 * Perform the subset test
	 * @param array $data 
	 * @return bool True if valid
	 */
	protected function subsetValid (array $data)
	{
		$cfg	= $this -> getConfig ();
		$diffs	= array_diff ($data, $cfg ['set']);
		return empty ($diffs);
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
				$valid	= $this -> subsetValid ($data);
			break;
			default			: 
				throw new \InvalidArgumentException (__CLASS__ . ': This property cannot be applied to data of type ' . gettype ($data));
			break;
		}
		return $valid;
	}
}
