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
 * Text matching prop
 * 
 * Test match properties implement the testing of text values in various ways, 
 * ranging from simple equality checks to regular expression matching.  All
 * text-matching properties implement the same format for their configuration,
 * namely a needle field that the string will be tested against. 
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Prop
 */
abstract class TextMatch extends Prop implements iface\prop
{
	/**
	 * Configure the property
	 * 
	 * Text match props all have a needle property that defines the string 
	 * against which the value will be tested.  This method implements the 
	 * needle setting
	 * 
	 * @param array $config
	 * @return TextMatch
	 * @throws \InvalidArgumentException 
	 */
	public function setConfig (array $config = array ())
	{
		if ((isset ($config ['needle']))
		&& (is_string ($config ['needle']))
		&& (strlen ($config ['needle']) > 0))
		{
			return parent::setConfig ($config);
		}
		else
		{
			throw new \InvalidArgumentException (__CLASS__ . ': The given configuration is not valid ' . var_export ($config, true));
		}
	}
}
