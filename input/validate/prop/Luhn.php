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
 * Prop for testing that a string validates against the Luhn algorithm
 * 
 * The Luhn algorithm is a simple checksum, commonly used to verify that 
 * credit-card numbers have been entered correctly.  
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Prop
 */
class Luhn extends abstr\Prop implements iface\Prop
{
	
	/**
	 * Apply the Luhn algorithim to the provided data
	 * 
	 * @param number $data
	 * @return bool True if the data passes the Luhn check
	 */
	protected function luhnValid ($data)
	{
		// Get the sequence of digits that make up the number under test
		$digits	= array_reverse (array_map ('intval', str_split ((string) $data)));
		
		// Walk the array, doubling the value of every second digit
		for ($i = 0, $count	= count ($digits); $i < $count; $i++)
		{
			if ($i % 2)
			{
				if (($digits [$i] *= 2) > 9)
				{
					// If doubling the digit resulted in a value > 9 then subtract 10 and add an extra 1 onto the array
					$digits [$i]	-= 10;
					$digits []		= 1;
				}
			}
		}
		
		// The Luhn is valid if the sum of the digits ends in a 0
		return (array_sum ($digits) % 10) === 0;
	}
	
	/**
	 * Test that the given data passes a Luhn check. 
	 * 
	 * @return bool True if the data passes the Luhn check
	 * @throws \InvalidArgumentException 
	 * @see http://en.wikipedia.org/wiki/Luhn_algorithm
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
			case 'integer'	:
				$valid	= $this -> luhnValid ($data);
			break;
			default			:
				// An attempt was made to apply the check to an invalid data type
				throw new \InvalidArgumentException (__CLASS__ . ': This property cannot be applied to data of type ' . gettype ($data));
			break;
		}
		
		return $valid;
	}
}
