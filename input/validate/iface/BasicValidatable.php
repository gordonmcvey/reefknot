<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\iface;

/**
 * Validatable interface
 * 
 * This interface defines methods that items that can be treated as validatable 
 * are expected to implement.  Currently, all the classes in the validate 
 * namespace implement this or one of its descentants, as each can be 
 * considered a validatable item in its own right. 
 * 
 * @author gordonmcvey
 */
interface BasicValidatable
{
	/**
	 * Set the parent element of the validatable
	 * 
	 * When a validatable is added to a container (A dataset), its parent 
	 * reference should be set back to the set to which it was added. 
	 * 
	 * @param DataSet $set
	 * @return Validatable The item should return itself so chaining can occur
	 * @throws \InvalidArgumentException
	 */
	public function setParent (Field $set);
	
	/**
	 * Get the parent element of the validatable
	 * 
	 * This method returns the parent valadatable, or NULL if this is the root
	 * valadatable. 
	 * 
	 * @return Validatable
	 */
	public function getParent ();
	
	/**
	 * Test whether the provided data is valid against the provided rules
	 * 
	 * @return bool True if the form is valid
	 */
	public function isValid ();
	
	/**
	 * Test whether the last run of isValid() resulted in validation errors
	 * 
	 * @return bool True if the last attempt to validate the assigned data failed
	 */
	public function hasInvalids ();
	
	/**
	 * Return a list of reasons why validation failed
	 * 
	 * This method returns a list of all the validatables that indicated that 
	 * the data they were given to process was invalid
	 * 
	 * @return array
	 */
	public function getInvalids ();
}
