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
 * Property functionality
 * 
 * Properties are constraints that data has to meet in order to be considered
 * valid.  The details of these constraints can be configured, for example a 
 * value that a numeric datum has to be below in order to be considered valid. 
 * The functionaliry for managing the configuration of Properties is defined 
 * here
 *
 * @author gordonmcvey
 */
abstract class Prop extends Validatable implements iface\Prop
{
	protected
		$config	= array ();
	
	/**
	 * Set the configuration for this Property
	 * 
	 * @param array $config
	 * @return Prop
	 */
	public function setConfig (array $config = array ())
	{
		$this -> config	= $config;
		return ($this);
	}
	
	/**
	 * Get the Property's current configuration
	 * 
	 * @return Array 
	 */
	public function getConfig ()
	{
		return ($this -> config);
	}
	
	/**
	 * Constructor for Properties
	 * 
	 * 
	 * @param array $config 
	 */
	public function __construct (array $config = array ())
	{
		$this -> setConfig ($config);
	}
}
