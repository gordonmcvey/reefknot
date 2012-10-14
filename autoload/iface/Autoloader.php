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
	 * Registering the autoloader will cause it to be appended to the end of the
	 * autoloader queue, unless the $push flag is set.  If it is, then it will
	 * be pushed into the front of the autoloader queue
	 * 
	 * Note: You can prevent a particular autoloader from operating by either
	 * unregistering it or by disabling it.  However, these aren't the same.  
	 * Disabling an autoloader will not remove it from the queue, just cause 
	 * its autoloading mechanism to be skipped.  Unregistering an autoloader
	 * will completely remove it from the queue.  This means that using the
	 * disable/enable semantics will not cause the order of autoloading to 
	 * change, but using the unregister/register semantics might.  
	 * 
	 * @param boolean $push Whether or not the autoloader should be pushed to the front of the autoload queue
	 * @return boolean True if the autoloader was successfully registered
	 */
	public function register ($push);
	
	/**
	 * Remove the autoloader from the autoloader queue
	 * 
	 * Unregistering the autoloader will cause it to be removed from the 
	 * autoloader queue.  This means the autoloader instance will no longer 
	 * take part in resolving unloaded classes.  
	 * 
	 * Note: You can prevent a particular autoloader from operating by either
	 * unregistering it or by disabling it.  However, these aren't the same.  
	 * Disabling an autoloader will not remove it from the queue, just cause 
	 * its autoloading mechanism to be skipped.  Unregistering an autoloader
	 * will completely remove it from the queue.  This means that using the
	 * disable/enable semantics will not cause the order of autoloading to 
	 * change, but using the unregister/register semantics might.  
	 * 
	 * @return boolean True if the autoloader was successfully unregistered
	 */
	public function unregister ();
	
	/**
	 * Returns whether or not the autoloader has been registered
	 * 
	 * @return boolean
	 */
	public function isRegistered ();
	
	/**
	 * Enable the autoloader
	 * 
	 * 
	 * @return Autoloader
	 */
	public function enable ();
	
	/**
	 * Disable the autoloader
	 * 
	 * Disabling an autoloader instance can be a useful optimization, as it 
	 * allows you to skip autoloaders that you know aren't set up to autoload 
	 * a particular class
	 * 
	 * Note: You can prevent a particular autoloader from operating by either
	 * unregistering it or by disabling it.  However, these aren't the same.  
	 * Disabling an autoloader will not remove it from the queue, just cause 
	 * its autoloading mechanism to be skipped.  Unregistering an autoloader
	 * will completely remove it from the queue.  This means that using the
	 * disable/enable semantics will not cause the order of autoloading to 
	 * change, but using the unregister/register semantics might.  
	 * 
	 * @return Autoloader
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
	 * @param string $namespace The root namespace that this instance will attempt to autoload for
	 * @param string $seperator The namespace seperator character
	 * @param string $suffix The class filename suffix
	 */
	public function __construct (	$path, 
									$namespace, 
									$seperator, 
									$suffix);

}
