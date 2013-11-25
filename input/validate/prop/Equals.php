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
 * Equality property
 * 
 * This class tests whether its value is equal to the value supplied to it in
 * the configuration provided.  
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package gordian\reefknot\input\validate\prop
 */
class Equals extends abstr\Prop implements iface\Prop
{
	/**
	 * Set configuration for the property
	 * 
	 * This property requires configuring to work.  The expected configuration
	 * is an associative array containing a 'value' that isn't NULL.  Any value
	 * can be provided (except NULL, as noted above).  A special case is that 
	 * you can provide an instance of a Field as the value.  Should you to this
	 * then the equality check will be carried out against whatever value the 
	 * field currently holds.  
	 * 
	 * @param array $config
	 * @return Equals
	 * @throws \InvalidArgumentException 
	 */
	public function setConfig (array $config = array ())
	{
		if (isset ($config ['value']))
		{
			return parent::setConfig ($config);
		}
		else
		{
			throw new \InvalidArgumentException (__CLASS__ . ': The given configuration is not valid  -- [ ' . var_export ($config, true) . ' ]');
		}
	}
	
	/**
	 * Test the equality of the provided data against the provided field's value
	 * 
	 * @param type $data
	 * @param iface\Field $field
	 * @return bool True if equal 
	 */
	protected function equalsField ($data, iface\Field $field)
	{
		return ($field === $this -> getParent () 
			|| (($field -> isValid ()) 
			&& ($data === $field -> getData ())));
	}
	
	/**
	 * Test the equality of this property against the supplied value
	 * 
	 * Validation of the property is done against the data stored in the 
	 * 'value' key of the config array.  The value can be of type iface\Field 
	 * in which case it will be compared against the value stored in the field,
	 * or it can be any other type in which case the values are compared 
	 * directly.  This allows you to test the value of the data under test 
	 * against a fixed value, or a value obtained from another field in a 
	 * data set.  This allows you to easily validate that one field in a data 
	 * set equals some other field.  
	 * 
	 * @return bool True if equal 
	 */
	public function isValid ()
	{
		$data	= $this -> getData ();
		
		return ((is_null ($data))
			|| (($cfg = $this -> getConfig ())
			&& ($cfg ['value'] instanceof iface\Field) 
			&& ($this -> equalsField ($data, $cfg ['value'])))
			|| ($data === $cfg ['value']));
	}
}
