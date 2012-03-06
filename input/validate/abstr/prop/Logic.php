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
abstract class Logic extends Prop implements iface\prop\Logic
{
	protected function isProp ($elem)
	{
		return ($elem instanceof iface\Prop);
	}
}
