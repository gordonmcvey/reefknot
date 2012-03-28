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
 * OneOf property
 * 
 * This property is used to composite a collection of other properties together
 * and test that the provided data matches one, and only one, of the properties
 * in the collection.  In other words, this property serves as an Exclosive Or
 * operation (xor)
 * 
 * @author gordonmcvey
 */
class OneOf extends abstr\prop\Logic implements iface\prop\Logic
{
	/**
	 * Set the configuration
	 * 
	 * To configure the object, an array with a 'props' key should be passed to
	 * the object.  This key should contain a collection of Props objects, 
	 * against which the value of the Prop will be tested. 
	 * 
	 * @param array $config
	 * @return OneOf
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
	 * For the data to be valid, it must validate against one, and only one, of 
	 * the Prop objects in the object's configuration.  This means that this 
	 * object behaves as an Exclusive Or operation
	 * 
	 * @return bool True if valid 
	 */
	public function isValid ()
	{
		$validCount	= 0;
		$data		= $this -> getData ();
		
		if (is_null ($data))
		{
			$validCount	= 1;
		}
		else
		{
			$cfg	= $this -> getConfig ();
			foreach ($cfg ['props'] as $prop)
			{
				if ($prop -> setData ($data) -> isValid ())
				{
					$validCount ++;
					if ($validCount > 1)
					{
						break;
					}
				}
			}
		}
		
		return ($validCount === 1);
	}
}
