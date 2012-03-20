<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate;

/**
 * DataSet validation unit
 * 
 * A dataset is a collection of one or more fields.  This collection can be used
 * to validate a set of data (an array) against the defined rules to see if it
 * is valid.  A dataset can also be a field, allowing for nested validation 
 * structures for testing nested arrays to be built.  
 *
 * @author Gordon McVey
 */
class DataSet extends Field implements iface\DataSet
{
	protected
		
		/**
		 * Collection of fields that belong to this dataset
		 * 
		 * @var array
		 */
		$fields			= array (),
		
		$globalProps	= array ();
	
	/**
	 * Register a field with the dataset
	 * 
	 * @param string $name
	 * @param iface\Node $field
	 * @return Field
	 * @throws \InvalidArgumentException If the given field has already been registered with the dataset
	 */
	public function addField ($name, iface\Node $field)
	{
		// Prevent the same field being added multiple times
		if (!in_array ($field, $this -> fields, true))
		{
			$this -> fields [$name]	= $field;
			$field -> setParent ($this);
		}
		else
		{
			throw new \InvalidArgumentException ('This field cannot be added to this group');
		}
		return ($this);
	}
	
	/**
	 * Unregister the named field from the dataset
	 * 
	 * @param type $name
	 * @return DataSet 
	 */
	public function deleteField ($name)
	{
		if (isset ($this -> fields [$name]))
		{
			unset ($this -> fields [$name]);
		}
		return ($this);
	}
	
	public function getField ($name)
	{

		return (isset ($this -> fields [$name])? 
				$this -> fields [$name]: 
				NULL);
	}
	
	/**
	 * Get a list of all fields currently registered with this dataset
	 * 
	 * @return array 
	 */
	public function getFields ()
	{
		return ($this -> fields);
	}
	
	/**
	 * Load data into fields
	 * 
	 * This method iterates over the fields assigned to the dataset and attempts
	 * to load them with data from the given data value.  
	 * 
	 * @param mixed $data
	 * @return DataSet
	 * @todo There's room for optimization here, lots of data gets copied when it doesn't need to be
	 */
	public function setData ($data = NULL)
	{
		$isArr	= is_array ($data);
		
		foreach ($this -> getFields () as $key => $field)
		{
			$field -> setData (($isArr) && (isset ($data [$key]))? 
				$data [$key]: 
				NULL);
		}
		return (parent::setData ($data));
	}
	
	/**
	 * Validate the data set
	 * 
	 * This method iterates over all the fields that have been defined for this 
	 * dataset and runs each one's validation rules in turn.  It will return a
	 * boolean that indicates whether all the defined fields validate against 
	 * their validation rules.  If the data set's fields are not valid, then 
	 * more detailed information about why the dataset failed validation can be
	 * obtained with the getInvalids () method.
	 * 
	 * @param array $data
	 * @return bool True if the data set is valid
	 * @todo Cache result of last run until internal state changes
	 */
	public function isValid ()
	{
		$this -> resetInvalids ();
		
		// Check that the supplied data meets its general validation constraints
		if (parent::isValid ())
		{
			/*
		 	 * Check each field that makes up the collection is valid
			 * @var $field iface\Field 
			 */
			foreach ($this -> getFields () as $key => $field)
			{
				if (!$field -> isValid ())
				{
					$this -> invalids [$key]	= $field -> getInvalids ();
				}
			}
		}
		return (!$this -> hasInvalids ());
	}
	
	/**
	 * Add a global property
	 * 
	 * A global property is a validation rule that gets applied to every field
	 * in the DataSet.  They are intended to allow easy validation of data that
	 * is expected to be quite uniform in nature.  
	 * 
	 * If a field in the set has a prop of the same type to it, then the field's
	 * prop will take presidence over the global prop.  For example, if you set
	 * a global Min prop of 12 then all text fields will be expected to be at 
	 * least 12 characters and all array will be expected to have at least 12
	 * elements.  However, if one of the fields in the set has its own Min prop
	 * set to 32, then that field will be expected to be at least 32 characters
	 * or elements long.  
	 * 
	 * @param iface\Prop $newProp
	 * @return type
	 * @throws \InvalidArgumentException 
	 */
	public function addGlobalProp (iface\Prop $newProp)
	{
		if (!in_array ($newProp, $this -> globalProps, true))
		{
			$this -> globalProps [get_class ($newProp)]	= $newProp;
			$newProp -> setParent ($this);
		}
		else
		{
			throw new \InvalidArgumentException ('This prop has already been added to this node');
		}
		return ($this);
	}
	
	/**
	 * Delete a global property
	 * 
	 * @param type $propName The class name of the property you want to remove
	 * @return DataSet 
	 */
	public function deleteGlobalProp ($propName)
	{
		if (isset ($this -> globalProps [$propName]))
		{
			unset ($this -> globalProps [$propName]);
		}
		return ($this);
	}
	
	/**
	 * Get list of global properties
	 * 
	 * @return array 
	 */
	public function getGlobalProps ()
	{
		return ($this -> globalProps);
	}
}
