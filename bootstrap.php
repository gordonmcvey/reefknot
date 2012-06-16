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
 * interface available for use.  It does not activate the autoloader, you need
 * to do that yourself by creating an instance of the autoloader class. This 
 * will put the autoloader into the SPL autoload stack. 
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Bootstrap
 */

const

	/**
	 * Shorthand for PHP's DIRECTORY_SEPERATOR constant 
	 */
	DS		= DIRECTORY_SEPARATOR,
	
	/**
	 * Framework root namespace 
	 */
	NS_FW	= __NAMESPACE__;

/**
 * Define the root path for the framework.  This can be overridden by defining
 * it before including the bootstrap 
 */
defined (NS_FW . '\PATH_FW')
	|| define (NS_FW . '\PATH_FW', realpath (__DIR__));

/**
 * Define the character used as the namespace seperator.  When using PHP 5.3 
 * namespacing, this is always the backslash character, but code written before 
 * 5.3 would often use an underscore or some other character to represent a 
 * namespace 
 */
defined (NS_FW .'\NS_SEP')
	|| define (NS_FW .'\NS_SEP', '\\');

// Load the autoloader
require	( PATH_FW . DS . 'autoload' . DS . 'iface' . DS . 'Autoloader.php');
require	( PATH_FW . DS . 'autoload' . DS . 'Autoloader.php');
