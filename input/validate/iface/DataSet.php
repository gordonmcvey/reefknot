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
}
