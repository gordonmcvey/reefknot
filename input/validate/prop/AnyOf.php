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
 * AnyOf property
 * 
 * This property is used to composite a collection of other properties together
 * and test that the provided data matches any one of the properties in the 
 * collection.  In other words, this property serves as an Or operation
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Prop
 */
class AnyOf extends abstr\prop\Logic implements iface\prop\Logic
{
	/**
	 * Set the configuration
	 * 
	 * To configure the object, an array with a 'props' key should be passed to
	 * the object.  This key should contain a collection of Props objects, 
	 * against which the value of the Prop will be tested. 
	 * 
	 * @param array $config
	 * @return AnyOf
	 * @throws \InvalidArgumentException 
	 */
	public function setConfig (array $config = array ())
	{
		if ((isset ($config ['props']))
		&& (is_array ($config ['props']))
		&& (!empty ($config ['props']))
		&& ($config ['props'] === array_filter ($config ['props'], array ($this, 'isProp'))))
		{
			return (parent::setConfig ($config));
		}
		else
		{
			throw new \InvalidArgumentException (__CLASS__ . ': The given configuration is not valid  -- [ ' . var_export ($config, true) . ' ]');
		}
	}
	
	/**
	 * Test that the property's data is valid
	 * 
	 * For the data to be valid, it must validate against at least one of the 
	 * Prop objects in its configuration.  In other words, this property 
	 * behaves as an Or operation. 
	 * 
	 * @return bool True if valid 
	 */
	public function isValid ()
	{
		$valid	= false;
		$data	= $this -> getData ();
		
		if (is_null ($data))
		{
			$valid	= true;
		}
		else
		{
			$cfg	= $this -> getConfig ();
			foreach ($cfg ['props'] as $prop)
			{
				if (($valid = $prop -> setData ($data) -> isValid ()) == true)
				{
					break;
				}
			}
		}
		
		return ($valid);
	}
}
