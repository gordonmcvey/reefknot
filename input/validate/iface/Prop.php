<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\iface;

/**
 * Property interface
 * 
 * This interfact defines the methods that Property validation units need to 
 * implement
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 */
interface Prop extends Rule
{
	/**
	 * Set the configuration for the property
	 * 
	 * Some properties need to be configured.  This method lets you specify the
	 * configuration for the property, using an associative array to set the 
	 * configuration options. 
	 * 
	 * @param array $config
	 * @return Prop
	 * @throws \InvalidArgumentException If you pass an invalid configuration 
	 */
	public function setConfig (array $config = array ());
	
	/**
	 * Get the property configuration
	 * 
	 * @return array 
	 */
	public function getConfig ();
	
	/**
	 * Property constrctor
	 * 
	 * @param array $config
	 * @throws \InvalidArgumentException If you pass an invalid configuration
	 */
	public function __construct (array $config = array ());
}
