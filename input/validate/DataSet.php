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
 * is valid.  
 * 
 * A dataset can also be a field, allowing for nested validation structures for 
 * validating nested arrays.
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 */
class DataSet extends Field implements iface\DataSet
{
	private
		
		/**
		 * Collection of fields that belong to this dataset
		 * 
		 * @var array
		 */
		$fields				= array (), 
		
		/**
		 * Flag that indicates whether the dataset meets the general 
		 * requirements specified for the dataset props (The data must be an 
		 * array or null, and it must meet any other props that have been 
		 * applied).  
		 * 
		 * @var bool
		 */
		$isDataProcessable	= false;
	
	/**
	 * Register a field with the dataset
	 * 
	 * This method adds a new Field object to the collection that will be 
	 * validated when isValid() is invoked.  
	 * 
	 * A field can only be added to a dataset once.  Attempts to add the same
	 * field more than once will trigger an exception.  
	 * 
	 * @param string $name
	 * @param iface\Node $field
	 * @return DataSet
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
	 * @param string $name
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
	 * Get the named field
	 * 
	 * This method returns the field registered for the given key, or NULL if 
	 * it doesn't exist. 
	 * 
	 * @param string $name
	 * @return iface\Field 
	 */
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
	 * their validation rules.  If any of the DataSet's fields are not valid, 
	 * then more detailed information about why the dataset failed validation 
	 * can be obtained with the getInvalids () method.
	 * 
	 * @return bool True if the data set is valid
	 * @todo Cache result of last run until internal state changes
	 */
	public function isValid ()
	{
		$this -> resetInvalids ();
		
		// Check that the supplied data meets its general validation constraints
		if (parent::isValid ())
		{
			$this -> setIsDataProcessable ();
			/*
		 	 * Check each field that makes up the collection is valid
			 * @var $field iface\Field 
			 */
			foreach ($this -> getFields () as $key => $field)
			{
				if (!$field -> isValid ())
				{
					$this -> addInvalid ($key, $field -> getInvalids ());
				}
			}
		}
		
		return (!$this -> hasInvalids ());
	}
	
	/**
	 * 
	 * @return boolean
	 */
	protected function isDataProcessable () {
		return $this -> isDataProcessable;
	}
	
	/**
	 * 
	 * @return \gordian\reefknot\input\validate\DataSet
	 */
	protected function setIsDataProcessable () {
		$this -> isDataProcessable	= true;
		return $this;
	}
	
	/**
	 * 
	 * @return \gordian\reefknot\input\validate\DataSet
	 */
	protected function resetIsDataProcessable () {
		$this -> isDataProcessable	= false;
		return $this;
	}
}
