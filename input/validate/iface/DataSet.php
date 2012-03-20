<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\iface;

/**
 *
 * @author gordonmcvey
 */
interface DataSet extends Node
{
	/**
	 * Add a field to the validation rules
	 * 
	 * @param string $name The name of the field to be validated (the array key)
	 * @param Node $field (The field rules to be applied)
	 * @return DataSet
	 * @throws \InvalidArgumentException
	 */
	public function addField ($name, Node $field);
	
	/**
	 * Remove a field from the validation rules
	 * 
	 * @param string $name
	 * @return DataSet
	 */
	public function deleteField ($name);
	
	/**
	 * Get list of fields for the data set
	 * 
	 * @return array
	 */
	public function getFields ();
	
	/**
	 * Get named field
	 * 
	 * @param string $name
	 * @return Field
	 */
	public function getField ($name);
	
	/**
	 * Add a global property
	 * 
	 * Global properties allow the same validation rule to be applied to all 
	 * fields within the DataSet.  This is useful when you are expecting your 
	 * data to all be of a uniform format. 
	 * 
	 * @param Prop $prop 
	 * @return DataSet
	 */
	public function addGlobalProp (Prop $newProp);
	
	public function deleteGlobalProp ($propName);
	
	/**
	 * Get the global preperties
	 * 
	 * @return array 
	 */
	public function getGlobalProps ();
}
