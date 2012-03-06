<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\type;

use 
	gordian\reefknot\input\validate\abstr, 
	gordian\reefknot\input\validate\iface;

/**
 * Description of IsMixed
 *
 * @author gordonmcvey
 */
class IsMixed extends abstr\Validatable implements iface\Type
{
	public function isValid ()
	{
		return (true);
	}
}
