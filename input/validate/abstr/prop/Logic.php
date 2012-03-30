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
 * Logic Prop 
 * 
 * A logic prop is a collection of several other standard props.  The validity
 * of the logic prop is a function of the validity of all the other props that
 * make up the collection.  
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Prop
 */
abstract class Logic extends Prop implements iface\prop\Logic
{
	/**
	 * Determine if the passed element is a prop
	 * 
	 * @param mixed $elem Element to test
	 * @return bool 
	 */
	protected function isProp ($elem)
	{
		return ($elem instanceof iface\Prop);
	}
}
