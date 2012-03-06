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
 * Regular expression matching property
 * 
 * This property can be used to test that a string matches a provided regular
 * expression.  It can only be used with strings. 
 *
 * @author gordonmcvey
 */
class RegexMatch extends abstr\prop\TextMatch implements iface\Prop
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
				$valid	= preg_match ($cfg ['needle'], $data) > 0;
			break;
			default			:
				throw new \InvalidArgumentException ();
			break;
		}
		
		return ($valid);
	}
}
