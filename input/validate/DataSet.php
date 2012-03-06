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
		 * @var array
		 */
		$fields	= array ();
	
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
}
