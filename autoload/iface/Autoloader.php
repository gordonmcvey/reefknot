<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload\iface;

/**
 * Autoloader interface
 * 
 * The Reefknot autoloader is quite simple.  Nonetheless, it was decided to 
 * include an interface anyway so that it can be easily replaced if necessary.
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Autoload
 * @subpackage Interfaces
 */
interface Autoloader
{
	/**
	 * Register the autoloader with the SPL autoload stack
	 * 
	 * @return bool True if the autoloader was successfully registered
	 */
	public function register ();
	
	/**
	 * Remove the autoloader from the SPL autoload stack
	 * 
	 * @return bool True if the autoloader was successfully unregistered
	 */
	public function unregister ();
	
	/**
	 * Set up autoloader
	 * 
	 * @param string $path The root path for classes
	 * @param string $namespace The namespace to restrict this instance of the autoloader to
	 * @param string $seperator The namespace seperator character
	 * @param string $suffix The class filename suffix
	 */
	public function __construct (	$path, 
									$namespace, 
									$seperator, 
									$suffix);

}
