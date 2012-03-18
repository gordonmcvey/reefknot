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
 * String match property
 * 
 * This property can be used to check that a given string contains the 
 * configured needle string within it.  Matching is case-sensitive. 
 *
 * @author gordonmcvey
 */
class Match extends abstr\prop\TextMatch implements iface\Prop
{
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
				$valid	= strpos ($data, $cfg ['needle']) !== false;
			break;
			default			:
				throw new \InvalidArgumentException (__CLASS__ . ': This property cannot be applied to data of type ' . gettype ($data));
			break;
		}
		
		return ($valid);
	}
}
