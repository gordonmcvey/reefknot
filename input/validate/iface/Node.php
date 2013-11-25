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
 * @author Gordon McVey
 * @category Reefknot
 * @package gordian\reefknot\input\validate\iface
 */
interface Node extends Validatable
{
	/**
	 * Add a property rule to the set
	 * 
	 * @param Prop $newProp
	 * @return Node
	 * @throws \InvalidArgumentException
	 */
	public function addProp (Prop $newProp);
	
	/**
	 * Delete a property from the set
	 * 
	 * @param string $propName The class name of the property to remove
	 * @return Node
	 */
	public function deleteProp ($propName);
	
	/**
	 * Get the list of set properties
	 * 
	 * @return array
	 */
	public function getProps ();
	
	/**
	 * Set the type the field is expected to have
	 * 
	 * @param Type $type
	 * @return Node
	 */
	public function setType (Type $type);
	
	/**
	 * Get the node's current type
	 * 
	 * @return Type
	 */
	public function getType ();
	
	/**
	 * Get the node's current rules
	 * 
	 * @return array 
	 */
	public function getRules ();
	
	/**
	 * Node constructor 
	 */
	public function __construct (Type $type);
}
