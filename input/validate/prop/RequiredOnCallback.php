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
 * Required conditional on callback result property
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Prop
 */
class RequiredOnCallback extends Required
{
	/**
	 * Configure the validator
	 * 
	 * The configuration for this validator consists of a required callback, and
	 * an optional argument list.  The contents of the args array are passed to 
	 * the callback in the order in which they were placed in the array.
	 * 
	 * @param array $config
	 * @return RequiredOnVal 
	 * @throws \InvalidArgumentException Thrown if the required keys don't exist
	 */
	public function setConfig (array $config = array ())
	{
		if ((isset ($config ['callback']))
		&& (is_callable ($config ['callback']))
		&& ((!array_key_exists ('args', $config)) 
		|| (is_array ($config ['args']))))
		{
			return parent::setConfig ($config);
		}
		else
		{
			throw new \InvalidArgumentException (__CLASS__ . ': The given configuration is not valid  -- [ ' . var_export ($config, true) . ' ]');
		}
	}
	
	/**
	 * Determine if the data meets its required constraint
	 * 
	 * This method utilises a callback to determine if this property is required
	 * to be non-empty.  If the callback returns true, then the property must 
	 * have a non-empty value and will be valid only if it is non-empty.  
	 * Otherwise, it isn't required to have a non-empty value and will always be 
	 * valid.  
	 * 
	 * @return bool True if valid 
	 */
	public function isValid ()
	{
		$valid	= false;
		$cfg	= $this -> getConfig ();
		
		// Make sure we don't pass a NULL to call_user_func_array
		if (!isset ($cfg ['args']))
		{
			$cfg ['args']	= array ();
		}

		// If our callback returns true then our data must be non-empty. 
		$valid	= ((bool) call_user_func_array ($cfg ['callback'], $cfg ['args']))?
			parent::isValid ():
			true;
		
		return ($valid);
	}
}
