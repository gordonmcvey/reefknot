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
 * Negation property
 * 
 * This property serves to invert the result of another property, allowing you 
 * to validate that the prop's value DOESN'T validate against the configured
 * property.  
 * 
 * @author gordonmcvey
 */
class Negate extends abstr\prop\Logic implements iface\prop\Logic
{
	/**
	 * Configure the Not property
	 * 
	 * The expected configuration for a Not is an associative array containing
	 * a 'Prop' element.  The value of the element must be an instance of an
	 * object that implements the Prop interface.  
	 * 
	 * @param array $config
	 * @return Negate
	 * @throws \InvalidArgumentException 
	 */
	public function setConfig (array $config = array ())
	{
		if ((isset ($config ['prop']))
		&& ($this -> isProp ($config ['prop'])))
		{
			return (parent::setConfig ($config));
		}
		else
		{
			throw new \InvalidArgumentException (__CLASS__ . ': The given configuration is not valid  -- [ ' . var_export ($config, true) . ' ]');
		}
	}
	
	/**
	 * Test that the property's value DOESN'T validate against the configured 
	 * property rule.  For example, if you want to validate that a string 
	 * doesn't match a particular regular expression, you'd configure a 
	 * RegexMax property with a pattern that you don't want the string to match
	 * and configure this Prop to ue it.  If the string matches the pattern in
	 * the RegexMatch, then false is returned.  Otherwise, a value of true is 
	 * returned.  
	 * 
	 * NOTE: If the property you're negating expects data of a particular type,
	 * then an exception will be thrown should the data assigned to this Prop
	 * is not of the expected type.  
	 * 
	 * @return bool 
	 */
	public function isValid ()
	{
		$data	= $this -> getData ();
		return ((is_null ($data))
			|| (($cfg = $this -> getConfig ()) 
			&& (!$cfg ['prop'] -> setData ($data) -> isValid ())));
	}
}
