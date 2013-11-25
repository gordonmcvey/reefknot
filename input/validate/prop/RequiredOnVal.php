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
 * Required conditional on other field property
 * 
 * This property allows for you to make a field in your dataset required on 
 * condition that another field is valid and either is or is not empty.  
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package gordian\reefknot\input\validate\prop
 */
class RequiredOnVal extends Required
{
	/**
	 * Set the dependant that will determine if the required property will be 
	 * applied
	 * 
	 * The config array consists of two keys.  The 'dependant' key contains the
	 * value which will be used to constrain this property.  If the dependant
	 * is a Validatable, then its value will be used as the dependant.  
	 * Otherwise, the value of the dependant will be used directly. 
	 * 
	 * The 'requireWhenEmpty' key is a switch that toggles the behaviour of the
	 * validity check between two modes.  When requireIsEmpty is set, the 
	 * validation will only require the data to have a value if the dependant is 
	 * empty.  If the flag is not set, then the validation will require the 
	 * data to have a value only if the dependant is not empty.
	 * 
	 * @param array $config
	 * @return RequiredOnVal 
	 * @throws \InvalidArgumentException Thrown if the required keys don't exist
	 */
	public function setConfig (array $config = array ())
	{
		if ((array_key_exists ('requireWhenEmpty', $config ))
		&& (array_key_exists ('dependant', $config )))
		{
			return parent::setConfig ($config);
		}
		else
		{
			throw new \InvalidArgumentException (__CLASS__ . ': The given configuration is not valid  -- [ ' . var_export ($config, true) . ' ]');
		}
	}
	
	/**
	 * Determine if the data is valid. 
	 * 
	 * Validation of the property occurs against the supplied dependant item. 
	 * The rules for validating this prop's data are as follows: 
	 * 
	 * If the requireWhenEmpty flag is set in the config, then our data is 
	 * required to have a value if the dependant does NOT have a value.  If the 
	 * dependant does have a value, then our data will be considered valid
	 * whether or not it has a value.  
	 * 
	 * If the requireWhenEmpty flag is not set, then our data is required to 
	 * have a value if the dependant DOES have a value.  If the dependant 
	 * doesn't have a value, then then our data will be considered valid 
	 * whether or not it has a value.  
	 * 
	 * If the dependant is a Validatable, then it must pass its own validation
	 * rules.  If it doesn't, then our data will always be considered invalid. 
	 * If the Validatable is valid, then our data will be tested against the
	 * data the Validatable holds.  If the dependant is not a Validatable then
	 * the value will be used directly. 
	 * 
	 * @return bool True if valid 
	 */
	public function isValid ()
	{
		$valid			= false;
		$canValidate	= false;
		$cfg			= $this -> getConfig ();
		
		// Determine if we are dealing with a Validatable instance
		if ($cfg ['dependant'] instanceof iface\Validatable)
		{
			// This validator can only pass if the field it depends on is also valid
			if (($canValidate = $cfg ['dependant'] -> isValid ()) !== false)
			{
				$dependantData	= $cfg ['dependant'] -> getData ();
			}
		}
		else
		{
			$canValidate	= true;
			$dependantData	= $cfg ['dependant'];
		}
		
		if ($canValidate)
		{
			if (empty ($cfg ['requireWhenEmpty']))
			{
				/*
				 * If the requireWhenEmpty flag is not set, then that means we
				 * require our data to have a value if the dependant has a 
				 * value.  If the dependant doesn't have a value then our data
				 * is considered valid regardless of its value. 
				 */
				$valid	= empty ($dependantData)?
					true:
					parent::isValid ();
			}
			else
			{
				/*
				 * If the requireWhenEmpty flag is set, then that means we 
				 * require our data to have a value if the dependant does NOT 
				 * have a value.  If the dependant DOES have a value, then our
				 * data is considered valid regardless of its value.  
				 */
				$valid	= empty ($dependantData)?
					parent::isValid ():
					true;
			}
		}
		
		return $valid;
	}
}
