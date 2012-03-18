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
 * Description of Luhn
 *
 * @author gordonmcvey
 */
class Luhn extends abstr\Prop implements iface\Prop
{
	public function isValid ()
	{
		$data	= $this -> getData ();
		$valid	= false;
		
		switch (gettype ($data))
		{
			case 'NULL'		:
				$valid	= true;
			break;
			case 'integer'	:
				// Get the sequence of digits that make up the number under test
				$digits	= array_reverse (array_map ('intval', str_split ((string) $data)));
				// Walk the array, doubling the value of every second digit
				for ($i = 0, $count	= count ($digits); $i < $count; $i++)
				{
					if ($i % 2)
					{
						// Double the digit
						if (($digits [$i] *= 2) > 9)
						{
							// Handle the case where the doubled digit is over 9
							$digits	[$i]	-= 10;
							$digits []		= 1;
						}
					}
				}
				// The Luhn is valid if the sum of the digits ends in a 0
				$valid	= ((array_sum ($digits) % 10) === 0);
			break;
			default			:
				// An attempt was made to apply the check to an invalid data type
				throw new \InvalidArgumentException (__CLASS__ . ': This property cannot be applied to data of type ' . gettype ($data));
			break;
		}
		
		return ($valid);
	}
}
