<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload;

/**
 * The autoloader for the Reefknot framework
 * 
 * The Reefknot autoloader is designed to be extremely lightweight.  It works
 * on the assumption that a namespace has a 1:1 mapping to a directory in the
 * filesystem, relative to the root path as defined by the NS_ROOT constant.  
 * It's this assumption that allows for such a lightweight autoloader.  
 * 
 * You can reuse the autoloader to provide autoloading services in your own 
 * projects by simply creating a new instance with the namespace and location 
 * of your project files as arguments.  If no arguments are provided then the 
 * new instance will default to the settings for loading Reefknot classes.  You
 * can also use this class to autoload "pseudo-namespaced" classes such as the
 * scheme used in PEAR and Zend Framework 1.x by specifying a different
 * namespace character.  Finally, you can subclass the autoloader for complete
 * control over its operation
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Autoload
 */
class Autoloader implements iface\Autoloader
{
	const
	
		/**
		 * Shortcut to the DIRECTORY_SEPARATOR PHP constant 
		 */
		DS				= \DIRECTORY_SEPARATOR;
	
	protected
		
		/**
		 * Character to use as the namespace separator.  If you're working with 
		 * PHP >= 5.3 then you will normally want to use the \ character as
		 * the namespace seperator.  If you're working with legacy code that 
		 * uses PEAR style pseudo-namespacing then you will probably want to 
		 * change this to the _ character, or to whatever convention you've 
		 * used in your code.  
		 * 
		 * @var string 
		 */
		$namespaceSep	= '',
		
		/**
		 * The namespace segment that should be considred the "root".  The
		 * autoloader will only attempt to load classes and interfaces within
		 * the root namespace 
		 * 
		 * @var string
		 */
		$namespaceRoot	= '',
		
		/**
		 * The root directory to search for classes and interfaces in.  Each 
		 * subnamespace maps to a subdirectory of this root directory.  
		 * 
		 * @var string
		 */
		$pathRoot		= '',
		
		/**
		 * Filename suffix to expect class and interface files to have
		 * 
		 * @var string 
		 */
		$fileSuffix		= '',
		
		/**
		 * Flag to determine if this instance of the autoloader has been 
		 * registered onto the SPL autoload stack
		 * 
		 * @var boolean
		 */
		$registered		= false,
		
		/**
		 * Flag to determine if this instance of the autoloader should attempt
		 * to load or whether it should just be skipped. 
		 * 
		 * @var boolean
		 */
		$enabled		= false;
	
	/**
	 * Determine if the given class is within the remit of this instance of the
	 * autoloader
	 * 
	 * @param string $name
	 * @return boolean
	 */
	protected function inRemit ($name)
	{
		return (false !== (strpos ($name, $this -> namespaceSep))
			&& (0 === strpos ($name, $this -> namespaceRoot)));
	}
	
	/**
	 * Generate the path from a namespaced resource name
	 * 
	 * This method determines where to expect a file containing the requested
	 * resource to be located in the filesystem.  This implementation does this 
	 * by replacing the namespace seperator with the directory seperator, 
	 * appending an expected filename suffix and prepending the autoloader's 
	 * root path
	 * 
	 * @param string $name 
	 * @return string
	 */
	protected function calculatePath ($name)
	{
		/* 
		 * We only want to use this autoloader on classes that are within the 
		 * specified namespace and use the correct namespace separator.  If the
		 * given name doesn't meet these specifications then it should be up to
		 * another autoloader to handle it. 
		 */
		return $this -> pathRoot 
			 . str_replace ($this -> namespaceSep, static::DS, str_replace ($this -> namespaceRoot, '', $name)) 
			 . $this -> fileSuffix;
	}
	
	/**
	 * Determine if a resource was loaded successfully
	 * 
	 * Once the autoloader has included the file that is expected to contain 
	 * the resource that's being requested, this method will check that the 
	 * requested resource is now actually available to PHP.  
	 * 
	 * In the context of autoloading, a resource is a class, interface or trait.
	 * 
	 * @param string $name Name of the resource to check
	 * @return boolean True if the resource is available
	 */
	protected function resourceLoaded ($name)
	{
		return ((class_exists ($name, false)) 
			|| (interface_exists ($name, false))
			|| ((function_exists ('trait_exists')) && (trait_exists ($name, false))));
	}
	
	/**
	 * Class/Interface autoloader
	 * 
	 * The autoloader expects to recieve a fully-namespaced class/interface name 
	 * as an argument.  It will check that the namespace for the class is within 
	 * its remit.  If it is then it will attempt to load the class/interface.  
	 * Otherwise, it will return false and leave autoloading of the class up to
	 * some other autoloader to handle.  
	 * 
	 * @param string $name The class to load, including namespace
	 */
	protected function load ($name)
	{
		$found	= false;
		
		if (($this -> isEnabled ())
		&& ($this -> inRemit ($name)))
		{
			$file	= $this -> calculatePath ($name);
			// Include the file if it exists and report success
			if (is_file ($file))
			{
				/*
				 * The reason we're going with include_once here is because if 
				 * we use include, there's a possibility that a class_exists 
				 * call could trigger a fatal error.  If you do a class_exists 
				 * that causes a file to be loaded but doesn't have the class
				 * in it, and then do it again on the same class later in the 
				 * script (say because you forgot to cache the result of the 
				 * previous call) then the second call could result in a fatal
				 * error.  It's my opinion that class_exists shouldn't ever 
				 * cause a fatal error (unless you do something really dumb 
				 * like pass in an empty string or some datatype that doesn't 
				 * cast to string)
				 */
				include_once $file;
				$found	= $this -> resourceLoaded ($name);
			}
		}
		
		return $found;
	}
	
	/**
	 * Register the autoload method with the SPL autoload stack
	 * 
	 * The optional $push parameter will determine whether the autoloader will 
	 * be added at the end of the autoload queue or at the start.  If false, 
	 * then the autoloader will be added at the end of the autoload queue, and
	 * will only be invoked if all autoloaders ahead of it have run and failed
	 * to load the requested class.  If true, the autoloader will be pushed to
	 * the front of the queue and will run before any other autoloaders.  The
	 * default is false.  
	 * 
	 * Note: You can prevent a particular autoloader from operating by either
	 * unregistering it or by disabling it.  However, these aren't the same.  
	 * Disabling an autoloader will not remove it from the queue, just cause 
	 * its autoloading mechanism to be skipped.  Unregistering an autoloader
	 * will completely remove it from the queue.  This means that using the
	 * disable/enable semantics will not cause the order of autoloading to 
	 * change, but using the unregister/register semantics might.  
	 * 
	 * @param boolean $push Whether or not to push the autoloader to the start of the autoload queue
	 * @return boolean True if the autoloader was registered successfully
	 */
	public function register ($push = false)
	{
		if (false === $this -> isRegistered ())
		{
			$this -> registered = spl_autoload_register (array ($this, 'load'), true, $push);
		}
		
		return $this -> isRegistered ();
	}
	
	/**
	 * Unregister the autoload method from the SPL autoload stack
	 * 
	 * Note: You can prevent a particular autoloader from operating by either
	 * unregistering it or by disabling it.  However, these aren't the same.  
	 * Disabling an autoloader will not remove it from the queue, just cause 
	 * its autoloading mechanism to be skipped.  Unregistering an autoloader
	 * will completely remove it from the queue.  This means that using the
	 * disable/enable semantics will not cause the order of autoloading to 
	 * change, but using the unregister/register semantics might.  

	 * @return boolean True is the autoloader was unregistered successfully
	 */
	public function unregister ()
	{
		if (true === $this -> isRegistered ())
		{
			$this -> registered	= !spl_autoload_unregister (array ($this, 'load'));
		}
		
		return !$this -> isRegistered ();
	}
	
	/**
	 * Determine whether the autoloader is registered
	 * 
	 * @return boolean
	 */
	public function isRegistered ()
	{
		return $this -> registered;
	}
	
	/**
	 * Enable the autoloader
	 * 
	 * Note: You can prevent a particular autoloader from operating by either
	 * unregistering it or by disabling it.  However, these aren't the same.  
	 * Disabling an autoloader will not remove it from the queue, just cause 
	 * its autoloading mechanism to be skipped.  Unregistering an autoloader
	 * will completely remove it from the queue.  This means that using the
	 * disable/enable semantics will not cause the order of autoloading to 
	 * change, but using the unregister/register semantics might.  
	 * 
	 * @return \gordian\reefknot\autoload\Autoloader
	 */
	public function enable ()
	{
		$this -> enabled	= true;
		return $this;
	}
	
	/**
	 * Disable the autoloader
	 * 
	 * Note: You can prevent a particular autoloader from operating by either
	 * unregistering it or by disabling it.  However, these aren't the same.  
	 * Disabling an autoloader will not remove it from the queue, just cause 
	 * its autoloading mechanism to be skipped.  Unregistering an autoloader
	 * will completely remove it from the queue.  This means that using the
	 * disable/enable semantics will not cause the order of autoloading to 
	 * change, but using the unregister/register semantics might.  
	 * 
	 * @return \gordian\reefknot\autoload\Autoloader
	 */
	public function disable ()
	{
		$this -> enabled	= false;
		return $this;
	}
	
	/**
	 * Determine whether the autoloader is currently enabled
	 * 
	 * @return boolean
	 */
	public function isEnabled ()
	{
		return $this -> enabled;
	}
	
	/**
	 * Initialize the autoloader
	 * 
	 * @param string $path The root path for class files
	 * @param string $namespace The namespace within which the autoloader will operate
	 * @param string $seperator The character(s) to treat as the namespace separator
	 * @param string $suffix The file suffix to expect for classes
	 */
	public function __construct (	$path, 
									$namespace, 
									$seperator = '\\', 
									$suffix = '.php')
	{
		// Set custom namespace props
		$this -> namespaceSep	= $seperator;
		$this -> namespaceRoot	= $namespace;
		$this -> pathRoot		= $path;
		$this -> fileSuffix		= $suffix;
		
		// Add this instance of the autoloader to the SPL autoload stack
		$this -> register ();
		$this -> enable ();
	}
}
