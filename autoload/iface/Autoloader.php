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
 * This interface defines a standardized Reefknot autoloading API.  Autoloaders
 * in Reefknot utilize the SPL autoloading functionality and therefore multiple 
 * autoloaders can be stacned up, and are intended to be well behaved so they
 * can be used alongside other similarly designed autoloading systems.  
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Autoload
 * @subpackage Interfaces
 */
interface Autoloader
{
	/**
	 * Register the autoloader with the autoloader queue
	 * 
	 * Classes implementing this interface will be added to the autoload queue
	 * by a call to the register method.  When called, the autoloader is 
	 * expected to append itself to the autoload queue, unless the $push flag is
	 * set.  In that case the autoloader is expected to push itself to the head
	 * of the autoload queue.  
	 * 
	 * @param boolean $push Whether or not to push the autoloader to the start of the autoload queue
	 * @return \gordian\reefknot\autoload\iface\Autoloader
	 * @throws \RuntimeException Thrown if registration failed
	 */
	public function register ($push);
	
	/**
	 * Remove the autoloader from the autoloader queue
	 * 
	 * Autoloaders implementing this interface can be removed from the autoload
	 * queue by calling this method.  When called, the autoloader is expected 
	 * to remove itsels from the autolaod queue
	 * 
	 * @return \gordian\reefknot\autoload\iface\Autoloader
	 * @throws \RuntimeException Thrown if registration failed
	 */
	public function unregister ();
	
	/**
	 * Returns whether or not the autoloader has been registered
	 * 
	 * This method is expected to return a true/false response, with true 
	 * indicating that the autoloader is currently in the autoload queue, and
	 * false otherwise. 
	 * 
	 * @return boolean
	 */
	public function isRegistered ();
	
	/**
	 * Enable the autoloader
	 * 
	 * Implementing classes are expected to enable their autoloader when this
	 * method is called, causing subsequent autoload attempts to use this 
	 * autoloader if previous autoloaders in the queue failed to load the class
	 * 
	 * Enabling/disabling is different from registering/unregistering, as there
	 * should be no change in the calling order of autoload methods if enable
	 * or disable is used.  As unregistering removes an autoloader from the 
	 * queue entirely, using register and unregister can change the order in 
	 * which autoloaders are executed.  
	 * 
	 * @return \gordian\reefknot\autoload\iface\Autoloader
	 */
	public function enable ();
	
	/**
	 * Disable the autoloader
	 * 
	 * Implementing classes are expected to disable their autoloader when this
	 * method is called, causing subsequent autoload attempts to bypass this 
	 * autoloader
	 * 
	 * Enabling/disabling is different from registering/unregistering, as there
	 * should be no change in the calling order of autoload methods if enable
	 * or disable is used.  As unregistering removes an autoloader from the 
	 * queue entirely, using register and unregister can change the order in 
	 * which autoloaders are executed.  
	 * 
	 * @return \gordian\reefknot\autoload\iface\Autoloader
	 */
	public function disable ();
	
	/**
	 * Returns whether or not the autoloader has been enabled
	 * 
	 * @return boolean
	 */
	public function isEnabled ();
	
	/**
	 * Set up autoloader
	 * 
	 * @param string $path The root path for classes
	 * @param string $namespace The root namespace that the autoloader will attempt to autoload for
	 * @param string $seperator The namespace seperator character
	 * @param string $suffix The class filename suffix
	 */
	public function __construct (	$path, 
									$namespace, 
									$seperator, 
									$suffix);
}
