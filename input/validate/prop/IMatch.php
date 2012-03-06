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
 * @author gordonmcvey
 */
class IMatch extends abstr\prop\TextMatch implements iface\Prop
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
				$valid	= stripos ($data, $cfg ['needle']) !== false;
			break;
			default			:
				throw new \InvalidArgumentException ('This validator can only be used on strings');
			break;
		}
		
		return ($valid);
	}
}
