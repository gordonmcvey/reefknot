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
 * Callback property
 * 
 * This property tests its value against a user-provided callback function. It
 * serves as one of the three ways of extending the functionality of the 
 * Validate package, the other two being subclassing a component in the package
 * or building classes that implement the package interfaces
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Prop
 */
class Callback extends abstr\Prop implements iface\Prop
{
	/**
	 * Configure the Callback prop
	 * 
	 * For Callback to work, it must be given a valid configuration.  This 
	 * configuration is an associative array containing a 'callback' key.  This
	 * key holds a reference to a callable piece of code (a method in a class,
	 * a function, an anonymous function, etc) that will be used for validating
	 * the data. 
	 * 
	 * Further configuration options can be included in an optional 'args' key, 
	 * which is expected to contain an array.  The first argument passed to the 
	 * callback function is always the data to be validated.  If the function 
	 * to be called needs additional arguments, they will be fetched from the 
	 * args array in order of appearence.  
	 * 
	 * @param array $config
	 * @return Callback
	 * @throws \InvalidArgumentException 
	 */
	public function setConfig (array $config = array ())
	{
		if ((isset ($config ['callback']))
		&& (is_callable ($config ['callback']))
		&& ((!isset ($config ['args'])) 
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
	 * Apply the callback to the data to test
	 * 
	 * @param mixed $data
	 * @return bool True if valid
	 */
	protected function callbackValid ($data)
	{
		$cfg	= $this -> getConfig ();
		$args	= array ();
		
		// Generate arguments for the callback
		if (isset ($cfg ['args']))
		{
			$args	= $cfg ['args'];
			array_unshift ($args, $data);
		}
		else
		{
			$args []	= $data;
		}
		
		// Execute the callback
		return (bool) call_user_func_array ($cfg ['callback'], $args);
	}
	
	/**
	 * Test the validity of the item's data
	 * 
	 * The item's data is considered valid if the callback it is passed to 
	 * returns a value that doesn't evaluate to false.  This is looser than 
	 * is usually expected throughout the validator package, most methods are
	 * expected to return boolean type values, but being less strict here makes
	 * life a bit easier when it comes to using pre-existing methods as 
	 * callbacks. 
	 * 
	 * You do need to be careful as a result, because anything that can return
	 * 0, an empty string, an empty array and so on for results that you want
	 * to be considered valid can fail the test.  For this reason you are 
	 * encouraged to only use methods that always return a boolean type under
	 * all circumstances to avoid the possible ambiguity that might be 
	 * introduced by using a callback.  Alternatively you can implement your 
	 * own Prop by subclassing one of the existing ones or by building one 
	 * that implements the necessary interfaces to be compatible with the 
	 * validator.  In fact that is the preferred approach. 
	 * 
	 * @return bool True if valid 
	 */
	public function isValid ()
	{
		$valid	= false;
		$data	= $this -> getData ();
		
		$valid	= !is_null ($data)?
			$this -> callbackValid ($data):
			true;
		
		return $valid;
	}
}
