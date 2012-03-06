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
abstract class Validatable extends BasicValidatable implements iface\Validatable
{
	protected
		/**
		 * @var mixed
		 */
		$data		= NULL; 
	
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
}
