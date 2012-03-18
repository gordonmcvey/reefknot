<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\abstr\prop;

use 
	gordian\reefknot\input\validate\iface,
	gordian\reefknot\input\validate\abstr\Prop;

/**
 *
 * @author gordonmcvey
 */
abstract class TextMatch extends Prop implements iface\prop
{
	public function setConfig (array $config = array ())
	{
		if ((isset ($config ['needle']))
		&& (is_string ($config ['needle']))
		&& (strlen ($config ['needle']) > 0))
		{
			return (parent::setConfig ($config));
		}
		else
		{
			throw new \InvalidArgumentException ('Invalid needle');
		}
	}
}
