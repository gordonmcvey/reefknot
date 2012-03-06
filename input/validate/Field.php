<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate;

/**
 * Field validation class
 * 
 * A field is the smallest unit of validation, and describes a single item to 
 * be validated (A PHP variable, an element in an array, a property of an 
 * object, etc).  A field has a data type, and a collection of rules that its
 * value must confirm to in order to be considered valid.  
 *
 * @author gordonmcvey
 */
class Field extends abstr\Node implements iface\Field
{
	protected
		/**
		 * @var iface\Type
		 */
		$type	= NULL; 
	
	/**
	 * Load data into field rules
	 * 
	 * This method iterates over the riles assigned to the field and attempts
	 * to load them with data from the given data value.  
	 * 
	 * @param mixed $data
	 * @return Field
	 * @todo There's room for optimization here, lots of data gets copied when it doesn't need to be
	 */
	public function setData ($data = NULL)
	{
		$this -> getType () -> setData ($data);
		foreach ($this -> getProps () as $rule)
		{
			$rule -> setData ($data);
		}
		return (parent::setData ($data));
	}
	
	/**
	 * Test that the provided value is valid according to the set rules
	 * 
	 * @return bool True if the field is valid according to the supplied rules
	 * @throws Exception If you attempt to run isValid without specifying a field type
	 */
	public function isValid ()
	{
		$this -> resetInvalids ();
		
		// Check that the field conforms to its rules
		foreach ($this -> getRules () as $rule)
		{
			if (!$rule -> isValid ())
			{
				$this -> invalids []	= get_class ($rule);
				//break;
			}
		}
		
		// Return validity test results
		return (!$this -> hasInvalids ());
	}
}
