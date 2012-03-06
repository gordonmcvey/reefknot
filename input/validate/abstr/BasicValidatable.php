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
 * Validator core functionality.  
 * 
 * The BasicValidatable class implements all the functionality that everything
 * that you can validate is supposed to implement.  Everything that you can 
 * validate can have a parent, and they also can be tested for validity by 
 * calling their isValid () method.  Not all validatables have data management
 * functionality, as some depend on the items that have been assigned to them. 
 * Therefore, the BasicValidatable class doesn't implement any data management
 * methods. 
 * 
 * @author gordonmcvey
 */
abstract class BasicValidatable implements iface\BasicValidatable
{
	protected
		/**
		 * Reference back to this item's parent. Can be NULL for root items
		 * 
		 * @var iface\Field
		 */
		$parent		= NULL, 
		
		/**
		 * List of reasons why the item failed validation are stored here
		 * 
		 * @var array
		 */
		$invalids	= array (); 
	
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
