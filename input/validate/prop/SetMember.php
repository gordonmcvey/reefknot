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
 * Description of SetMember
 *
 * @author gordonmcvey
 */
class SetMember extends abstr\Prop implements iface\Prop
{
	public function setConfig (array $config = array ())
	{
		if ((isset ($config ['set']))
		&& (is_array ($config ['set']))
		&& (!empty ($config ['set'])))
		{
			return (parent::setConfig ($config));
		}
		else
		{
			throw new \InvalidArgumentException ();
		}
	}
	
	public function isValid ()
	{
		$cfg	= $this -> getConfig ();
		$data	= $this -> getData ();
		
		return ((is_null ($data))
			|| (in_array ($data, $cfg ['set'], true)));
	}
}
