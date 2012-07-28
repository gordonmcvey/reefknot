<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot;

/**
 * Framework bootstrapper 
 * 
 * This file contains the code needed to bootstrap the framework's autoloader.
 * Including this file in your code will set up some parameters the autoloader
 * depends on to work and makes the autoloader class and its associated 
 * interface available for use.  It does not instantiate an autoloader instance, 
 * you need to do that yourself by calling new Autoloader (). 
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Bootstrap
 */

const

	/**
	 * Shorthand for PHP's DIRECTORY_SEPERATOR constant.
	 */
	DS		= DIRECTORY_SEPARATOR,
	
	/**
	 * Framework root namespace.
	 */
	NS_FW	= __NAMESPACE__, 
	
	/**
	* Define the character used as the namespace seperator.
	*/
	NS_SEP	= '\\',
	
	/**
	 * Define the minimum PHP version currently supported by Reefknot
	 */
	PHP_MIN	= '5.3.10';

// Abort with a fatal error should the PHP version requirements not be met
if (version_compare (PHP_VERSION, PHP_MIN) < 0)
{
	trigger_error (	'Reefknot requires PHP version ' 
					. PHP_MIN . ' or higher. Version ' 
					. PHP_VERSION . ' detected. Aborting' 
					. PHP_EOL, E_USER_ERROR);
}

/**
 * Define the root path for the framework.  This can be overridden by defining
 * it before including the bootstrap 
 */
defined (__NAMESPACE__ . '\PATH_FW')
	|| define (__NAMESPACE__ . '\PATH_FW', realpath (__DIR__));

// Load the autoloader
require	( PATH_FW . DS . 'autoload' . DS . 'iface' . DS . 'Autoloader.php');
require	( PATH_FW . DS . 'autoload' . DS . 'Autoloader.php');
