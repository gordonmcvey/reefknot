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
		 * @var iface\Type 
		 */
		$globalType		= NULL,
		
		/**
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
	
	public function setGlobalType (iface\Type $newType)
	{
		$this		-> globalType	= $newType;
		$newType	-> setParent ($this);
		return ($this);
	}
	
	public function getGlobalType ()
	{
		return ($this -> globalType);
	}
	
	public function getGlobalRules ()
	{
		$type	= $this -> getGlobalType ();
		return (array_merge (array (get_class ($type) => $type), $this -> getGlobalProps ()));
	}
	
	public function isValid ()
	{
		// Run the standard validation
		parent::isValid ();
		
		// Run the global validation
		$rules	= $this -> getGlobalRules ();
		
		var_dump (array_keys ($rules), array_map (function ($elem){return (get_class ($elem));}, $rules));
		
		$data	= $this -> getData ();
		if (is_array($data))
		{
			foreach ($data as $dataKey => $data)
			{
				$invalids	= array ();
				foreach ($rules as $propKey => $prop)
				{
					$prop -> setData ($data);
					if (!$prop -> isValid ())
					{
						$invalids [] = $propKey;
					}
				}
				if (!empty ($invalids))
				{
					$this -> invalids [$dataKey]	= $invalids;
				}
			}
		}
		
		// Return validity
		return (!$this -> hasInvalids ());
	}
}
