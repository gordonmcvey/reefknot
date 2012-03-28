<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\abstr;

use gordian\reefknot\input\validate\iface;

/**
 * Validatable functionality
 * 
 * Validation in Reefknot is accomplished by collections of Validatable objects.
 * A Validatable embodies a piece of data, and the rules necessary to test that
 * the data is valid.  The rules that perform the validation are themselves 
 * Validatables of various types.  
 *
 * @author gordonmcvey
 */
abstract class Validatable implements iface\Validatable
{
	protected
		
		/**
		 * Reference back to this item's parent. Can be NULL for root items
		 * 
		 * @var iface\Node
		 */
		$parent		= NULL, 
		
		/**
		 * The data to be validated 
		 * 
		 * @var mixed
		 */
		$data		= NULL, 
		
		/**
		 * List of reasons why the item failed validation are stored here
		 * 
		 * @var array
		 */
		$invalids	= array (); 
	
	/**
	 * Set the data to be validated
	 * 
	 * @param mixed $data
	 * @return Validatable 
	 */
	public function setData ($data = NULL)
	{
		$this -> data	= $data;
		return ($this);
	}
	
	/**
	 * Get the data that has been set for this item
	 * 
	 * @return mixed 
	 */
	public function getData ()
	{
		return ($this -> data);
	}
	
	/**
	 * Set the parent node of this validatable.  
	 * 
	 * @param iface\Node $set The node that is to become the validatable's parent
	 * @return Validatable
	 * @throws \InvalidArgumentException 
	 */
	public function setParent (iface\Node $set)
	{
		if (($this -> parent === NULL)
		|| ($this -> parent === $set))
		{
			$this -> parent	= $set;
		}
		else
		{
			throw new \InvalidArgumentException ('This field already has a parent');
		}
		return ($this);
	}
	
	/**
	 * Get the parent node of this validatable
	 * 
	 * @return iface\Node 
	 */
	public function getParent ()
	{
		return ($this -> parent);
	}
	
	/**
	 * Clear the validation error list
	 * 
	 * @return Validatable 
	 */
	public function resetInvalids ()
	{
		$this -> invalids	= array ();
		return ($this);
	}
	
	/**
	 * Get list of validation failures
	 * 
	 * @return array 
	 */
	public function getInvalids ()
	{
		return ($this -> invalids);
	}
	
	/**
	 * Return whether or not the validatable has invalid data
	 * 
	 * @return bool 
	 */
	public function hasInvalids ()
	{
		return (!empty ($this -> invalids));
	}
}
