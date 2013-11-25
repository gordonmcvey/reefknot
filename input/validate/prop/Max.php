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
 * Prop for constraining the maximum value the data can take
 * 
 * The Max property restricts the size of the given data to the maximum size 
 * specified in the config.  
 * 
 * The property is context-sensitive.  Max has a different meaning determined by
 * the kind of data it is operating on:
 * 
 * * For numeric data (int anf float) the Max specifies the maximum allowed 
 *   numeric value.  For example, if you set a Max of 4, then values of 3.5 or 1
 *   would be considered valid. 
 * * For strings, the Max specifies the maximum string length allowed.  For 
 *   example, if you specify a Mac of 4, then the string 'fish' would be valid,
 *   but the string 'chips' would not. 
 * * For arrays, the Max specifies the maximum number of elements the array 
 *   must have.  If you specify a Max of 6, then an array will only be valid if
 *   it has 6 elements or less. 
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package gordian\reefknot\input\validate\prop
 */
class Max extends abstr\prop\Ranged implements iface\prop\Ranged
{
	/**
	 * Test that the given data conforms to the maximum size specified. 
	 * 
	 * As discussed above, the meaning of 'size' is context-sensitive. 
	 * 
	 * @return bool True if the data meets or is below the maximum
	 * @throws \InvalidArgumentException
	 */
	public function isValid ()
	{
		$valid	= false;
		$limit	= NULL;
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
					$valid	= $data <= $limit;
				}
			break;
			case 'string'	:
				$cfg	= $this -> getConfig ();
				if (($limit	= $this -> getLimit ($cfg ['limit'])) !== NULL)
				{
					$valid	= strlen ($data) <= $limit;
				}
			break;
			case 'array'	:
				$cfg	= $this -> getConfig ();
				if (($limit	= $this -> getLimit ($cfg ['limit'])) !== NULL)
				{
					$valid	= count ($data) <= $limit;
				}
			break;
			default			:
				throw new \InvalidArgumentException (__CLASS__ . ': This property cannot be applied to data of type ' . gettype ($data));
			break;
		}
		
		return $valid;
	}
}
