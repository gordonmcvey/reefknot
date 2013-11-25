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
 * A globalized data set is an extention of the standard data set, which adds
 * global rules.  A global rule is a test that will be applied to every member
 * of the data set being validated.  This allows you to quickly and easily 
 * build relatively simple validators for collections of data you expect to have
 * fairly regular content.  
 * 
 * Globalized datasets provide all the same functionality as the regular 
 * dataset does, so you can also define specific rules to individual fields that
 * will be applied as well.  This means that the globalized dataset can also
 * be used in situations where most of the fields in a set are expected to 
 * have a uniform format, but one or two of them are expected to be 
 * significantly different.  
 * 
 * In the event that a field in the set has a validation rule of the same type
 * as a global rule, the field's rule will take priority.  For example, if you 
 * set a global Min prop of 12 then all text fields will be expected to be at 
 * least 12 characters and all array will be expected to have at least 12 
 * elements.  However, if one of the fields in the set has its own Min prop
 * set to 32, then that field will be expected to be at least 32 characters or
 * elements long. 
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package gordian\reefknot\input\validate
 */
class DataSetGlobalized extends DataSet implements iface\DataSetGlobalized
{
	/**
	 * Expected type for all fields
	 *
	 * @var iface\Type
	 */
	private	$globalType		= NULL;

	/**
	 * Props to apply to all fields
	 *
	 * @var array
	 */
	private	$globalProps	= array ();

	/**
	 * List of fields that failed validation due to global invalids and why
	 *
	 * @var array
	 */
	private	$globalInvalids	= array ();
	
	/**
	 * Get the global invalid field list
	 * 
	 * @return array 
	 */
	public function getGlobalInvalids ()
	{
		return $this -> globalInvalids;
	}
	
	/**
	 * Reset the invalid fields list in preparation for another run 
	 * 
	 * @return DataSetGlobalized 
	 */
	public function resetInvalids ()
	{
		$this -> globalInvalids	= array ();
		return parent::resetInvalids ();
	}
	
	/**
	 * Return whether or not the last run of the validation rules resulted in errors
	 * 
	 * @return bool 
	 */
	public function hasInvalids ()
	{
		return (!empty ($this -> globalInvalids))
			|| (parent::hasInvalids ());
	}
	
	/**
	 * Add a global property
	 * 
	 * A global property is a validation rule that gets applied to every field
	 * in the DataSet.  They are intended to allow easy validation of data that
	 * is expected to be quite uniform in nature.  
	 * 
	 * @param \gordian\reefknot\input\validate\iface\Prop $newProp
	 * @return \gordian\reefknot\input\validate\DataSetGlobalized
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
		return $this;
	}
	
	/**
	 * Delete a global property
	 * 
	 * @param string $propName The class name of the property you want to remove
	 * @return \gordian\reefknot\input\validate\DataSetGlobalized
	 */
	public function deleteGlobalProp ($propName)
	{
		if (isset ($this -> globalProps [$propName]))
		{
			unset ($this -> globalProps [$propName]);
		}
		return $this;
	}
	
	/**
	 * Get list of global properties
	 * 
	 * @return array 
	 */
	public function getGlobalProps ()
	{
		return $this -> globalProps;
	}
	
	/**
	 * Set the type that all fields in the dataset are expected to be.  
	 * 
	 * @param \gordian\reefknot\input\validate\iface\Type $newType
	 * @return \gordian\reefknot\input\validate\DataSetGlobalized
	 */
	public function setGlobalType (iface\Type $newType)
	{
		$this		-> globalType	= $newType;
		$newType	-> setParent ($this);
		return $this;
	}
	
	/**
	 * Get the globalized type
	 * 
	 * @return iface\Type 
	 */
	public function getGlobalType ()
	{
		return $this -> globalType;
	}
	
	/**
	 * Get the validation rules that all fields in the dataset are expected to match
	 * 
	 * This method returns an array of Rule objects, the first one of which is 
	 * the Type.  The others are the props.  This collection of rules will be
	 * applied to all fields in the dataset when the validation runs.  
	 * 
	 * @return array 
	 */
	public function getGlobalRules ()
	{
		$type	= $this -> getGlobalType ();
		return array_merge (array (get_class ($type) => $type), $this -> getGlobalProps ());
	}
	
	/**
	 * Apply the global rules to the given field
	 * 
	 * @param array $rules
	 * @param string $fieldName
	 * @param mixed $fieldData
	 * @return array 
	 */
	protected function applyRules (array $rules, $fieldName, $fieldData)
	{
		$invalids	= array ();
		$fieldRules	= array ();
		
		// Get any rules that may exist for the field.
		if (($field = $this -> getField ($fieldName)) !== NULL)
		{
			$fieldRules	= $field -> getRules ();
		}
		
		// Apply the global rules to the field
		foreach ($rules as $ruleKey => $rule)
		{
			/*
			 * We only want to apply the global rules if the field doesn't have 
			 * conflicting rules of its own.  If the field has any rules at all
			 * then it must have a type, so we'll use the field's type to 
			 * determine type validity.  If the field has a property of the 
			 * same kind as a global property, then we'll use the field's prop.
			 * Otherwise the global prop will be applied.  
			 */
			if ((($rule instanceof iface\Type) && (empty ($fieldRules)))
			|| (($rule instanceof iface\Prop) && (!array_key_exists ($ruleKey, $fieldRules))))
			{
				$rule -> setData ($fieldData);
				if (!$rule -> isValid ())
				{
					$invalids [] = $ruleKey;
				}
			}
		}
				
		return $invalids;
	}
	
	/**
	 * Run the validation rules
	 * 
	 * This method runs the field rules, then applies the globalized rules. 
	 * 
	 * @return bool True if the given data is valid
	 */
	public function isValid ()
	{
		// Run the standard validation
		parent::isValid ();
		
		if ($this -> isDataProcessable ())
		{
			// Run the global validation
			$rules	= $this -> getGlobalRules ();
			$data	= $this -> getData ();
			
			/*
			 * Unlike a standard dataset (which is expected to only contain 
			 * the defined fields), a globalized dataset can contain any number
			 * of fields.  They all get the same rules applied to them.  
			 * Therefore we want to iterate over the data instead of the field
			 * objects to apply the validation rules.  
			 */
			if (is_array ($data))
			{
				foreach ($data as $fieldName => $fieldData)
				{
					if ($invalids = $this -> applyRules ($rules, $fieldName, $fieldData))
					{
						$this -> globalInvalids [$fieldName]	= $invalids;
					}
				}
			}
		}
		
		// Return validity
		return !$this -> hasInvalids ();
	}
}
