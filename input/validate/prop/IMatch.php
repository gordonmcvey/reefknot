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
 * Case insensitive string match property
 * 
 * This property tests that a given string contains the configured needle string
 * within it, regardless of character case. 
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package gordian\reefknot\input\validate\prop
 */
class IMatch extends abstr\prop\TextMatch implements iface\Prop
{
	/**
	 * Check that the given data contains the specified string within it in a 
	 * case-insensitive manner
	 * 
	 * @return bool True if the given data contains the specified string
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
			case 'string'	:
				$cfg	= $this -> getConfig ();
				$valid	= stripos ($data, $cfg ['needle']) !== false;
			break;
			default			:
				throw new \InvalidArgumentException (__CLASS__ . ': This property cannot be applied to data of type ' . gettype ($data));
			break;
		}
		
		return $valid;
	}
}
