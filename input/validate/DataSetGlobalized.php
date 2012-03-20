<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate;

/**
 * Globalized Data Set
 * 
 * 
 * @author Gordon McVey
 */
class DataSetGlobalized extends DataSet implements iface\DataSetGlobalized
{
	protected
		
		/**
		 * 
		 * @var array
		 */
		$globalProps	= array ();
		
	
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
	
	public function isValid ()
	{
		// Run the global validation
		
		$props	= $this -> getGlobalProps ();
		foreach ($this -> getData() as $dataKey => $data)
		{
			foreach ($props as $propKey => $prop)
			{
				$prop -> setData ($data);
				if (!$prop -> isValid ())
				{
					$this -> invalids [$dataKey][] = $propKey;
				}
			}
		}
		
		// Run the standard validation
		parent::isValid ();
		
		// Return validity
		return (!$this -> hasInvalids ());
	}
}
