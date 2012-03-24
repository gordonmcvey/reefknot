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
 * Most validatable items have data associated with them.  This class implements
 * the data management portion of validatable objects.  
 *
 * @author gordonmcvey
 */
abstract class Validatable implements iface\Validatable
{
	protected
		/**
		 * Reference back to this item's parent. Can be NULL for root items
		 * 
		 * @var iface\Field
		 */
		$parent		= NULL, 
		
		/**
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
	
	public function setParent (iface\Field $set)
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
	
	public function getParent ()
	{
		return ($this -> parent);
	}
	
	public function resetInvalids ()
	{
		$this -> invalids	= array ();
		return ($this);
	}
	
	public function getInvalids ()
	{
		return ($this -> invalids);
	}
	
	public function hasInvalids ()
	{
		return (!empty ($this -> invalids));
	}
}
