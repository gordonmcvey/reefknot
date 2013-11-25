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
 * Email property
 * 
 * This property can be applied to strings to see if the string appears to 
 * encode a valid email address.  
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package gordian\reefknot\input\validate\prop
 */
class Email extends abstr\Prop implements iface\Prop
{
	/**
	 * Validate that this object's data is a valid email address
	 * 
	 * This method depends on the underlying PHP filter_var function with the
	 * FILTER_VALIDATE_EMAIL parameter.  As a consequence, there are some cases
	 * where false negatives can occur (addresses that whilst unusual are valid
	 * can be rejected as invalid).  
	 * 
	 * @return bool True if valid
	 * @throws \InvalidArgumentException 
	 * @todo using filter_var doesn't seem to be entirely reliable.  Look into more robust alternatives
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
				$valid	= (filter_var ($data, FILTER_VALIDATE_EMAIL)) !== false;
			break;
			default			:
				throw new \InvalidArgumentException (__CLASS__ . ': This property cannot be applied to data of type ' . gettype ($data));
			break;
		}
		
		return $valid;
	}
}
