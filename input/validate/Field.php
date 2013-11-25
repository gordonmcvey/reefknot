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
 * A field is a unit of validation that describes the rules that determine if a
 * given piece of data is valid.  The piece of data in tested against each of 
 * the provided rules in turn to determine if it conforms to them.  If it 
 * conforms to all the rules then the data is considered to be valid.  If the
 * data is not valid then a list of reasons why the data failed validation is
 * provided fo that the approporiate action can be taken.  
 * 
 * Fields are intended to be used to validate non-composite types of data (or 
 * scalars, to use the proper terminology). While they can be used for 
 * validating some aspects of composite data types (arrays and objects), they 
 * can only check validity regarding properties of the composite as a whole 
 * (mostly, how many elements the composite contains).  A Field does not attempt 
 * to process the elements that make up the composite.  For this case, you 
 * should use DataSet (if the keys are known) or DataSetGlobalized (if they are
 * not) instead, as they implement the Field interface and can be used in 
 * validation as fields, but they also process the elements that make the data
 * up.  
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package gordian\reefknot\input\validate
 */
class Field extends abstr\Node implements iface\Field
{
	
	/**
	 * Load data into field rules
	 * 
	 * This method iterates over the rules assigned to the field and attempts
	 * to load them with data from the given data value.  
	 * 
	 * @param mixed $data The data to be validated
	 * @return Field Returns its own instance for method chaining. 
	 * @todo There's room for optimization here, lots of data gets copied when it doesn't need to be
	 */
	public function setData ($data = NULL)
	{
		$this -> getType () -> setData ($data);
		
		foreach ($this -> getProps () as $rule)
		{
			$rule -> setData ($data);
		}
		
		return parent::setData ($data);
	}
	
	/**
	 * Test that the provided value is valid according to the set rules
	 * 
	 * This method iterates over all the rules specified to determine the 
	 * validity of the provided data.  If all the rules return that the data 
	 * is valid then the method will return that the data is valid.  The data
	 * is only valid if all the rules are valid.  Any invalid rules will cause
	 * this method to return false. 
	 * 
	 * @return bool True if the field is valid according to the supplied rules
	 */
	public function isValid ()
	{
		$this -> resetInvalids ();
		
		// Check that the field conforms to its rules
		foreach ($this -> getRules () as $rule)
		{
			if (!$rule -> isValid ())
			{
				//$this -> invalids []	= get_class ($rule);
				$this -> addInvalid (NULL, get_class ($rule));
				//break;
			}
		}
		
		// Return validity test results
		return !$this -> hasInvalids ();
	}
}
