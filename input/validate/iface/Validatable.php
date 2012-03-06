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
 * This interface designates a "full" validatable item that includes data
 * management as well as the standard validation features of the core 
 * BasicValidatable interface.  Most kinds of validation units in the validate
 * package implement this interface, the notable exception being groups.
 * 
 * @author gordonmcvey
 */
interface Validatable extends BasicValidatable
{
	/**
	 * Set the data to be validated
	 * 
	 * @param mixed $data
	 * @return Validatable
	 */
	public function setData ($data = NULL);
	
	/**
	 * Get the data to be validated back
	 * 
	 * @return mixed
	 */
	public function getData ();
}
