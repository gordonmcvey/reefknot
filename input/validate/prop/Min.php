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
 * Prop for constraining the minimum value the data can take
 * 
 * The Min property restricts the size of the given data to the minimum size 
 * specified in the config.  
 * 
 * The property is context-sensitive.  Min has a different meaning determined by
 * the kind of data it is operating on:
 * 
 * * For numeric data (int anf float) the Min specifies the minimum allowed 
 *   numeric value.  For example, if you set a Min of 4, then values of 4.5 or 9
 *   would be considered valid. 
 * * For strings, the Min specifies the minimum string length allowed.  For 
 *   example, if you specify a Min of 5, then the string 'chips' would be valid,
 *   but the string 'fish' would not. 
 * * For arrays, the Min specifies the minimum number of elements the array 
 *   must have.  If you specify a Min of 6, then an array will only be valid if
 *   it has 6 elements or more. 
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Prop
 */
class Min extends abstr\prop\Ranged implements iface\prop\Ranged
{
	/**
	 * Test that the given data conforms to the minimum size specified. 
	 * 
	 * As discussed above, the meaning of 'size' is context-sensitive. 
	 * 
	 * @return bool True if the data meets or exceeds the minimum
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
			case 'integer'	:
			case 'double'	:
				$cfg	= $this -> getConfig ();
				if (($limit	= $this -> getLimit ($cfg ['limit'])) !== NULL)
				{
					$valid	= $data >= $limit;
				}
			break;
			case 'string'	:
				$cfg	= $this -> getConfig ();
				if (($limit	= $this -> getLimit ($cfg ['limit'])) !== NULL)
				{
					$valid	= strlen ($data) >= $limit;
				}
			break;
			case 'array'	:
				$cfg	= $this -> getConfig ();
				if (($limit	= $this -> getLimit ($cfg ['limit'])) !== NULL)
				{
					$valid	= count ($data) >= $limit;
				}
			break;
			default			:
				throw new \InvalidArgumentException (__CLASS__ . ': This property cannot be applied to data of type ' . gettype ($data));
			break;
		}
		return ($valid);
	}
}
