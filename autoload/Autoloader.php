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
 * filesystem, relative to the root path given when the autoloader is 
 * instantiated. It's this assumption that allows for such a lightweight 
 * autoloader.  
 * 
 * You can reuse the autoloader to provide autoloading services in your own 
 * projects by simply creating a new instance with the namespace and location 
 * of your project files as arguments.  You can also use this class to autoload 
 * "pseudo-namespaced" classes such as the scheme used in PEAR and Zend 
 * Framework 1.x by specifying a different namespace character.  Finally, you 
 * can subclass the autoloader for complete control over its operation
 * 
 * The following class documentation makes reference to "resources".  In the 
 * context of the autoloader, a resource is a class, interface, or trait (for 
 * PHP >= 5.4)
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
	
	private
		
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
		 * autoloader will only attempt to load resources within the root 
		 * namespace
		 * 
		 * @var string
		 */
		$namespaceRoot	= '',
		
		/**
		 * The root directory to search for resources in.  Each  subnamespace 
		 * maps to a subdirectory of this root directory.  
		 * 
		 * @var string
		 */
		$pathRoot		= '',
		
		/**
		 * Filename suffix to expect resource files to have
		 * 
		 * @var string 
		 */
		$fileSuffix		= '',
		
		/**
		 * Flag to determine if this instance of the autoloader has been 
		 * registered onto the SPL autoload queue
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
	 * Determine if the given resource is within the remit of this instance of 
	 * the autoloader
	 * 
	 * The autoloader is set up with a "root namespace" on creation.  The 
	 * autoloader is only supposed to attempt to load classes that are within 
	 * that namespace, skpping any that aren't and leaving them for another 
	 * autoloader to handle.  For example, if you set 'foo' as the root 
	 * namespace, then the autoloader should load '\foo\MyClass', but it should
	 * not attempt to load '\bar\MyClass'
	 * 
	 * @param string $name
	 * @return boolean True if the given resource name is within the remit of this autoloader
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
	 * The autoloader expects to recieve a fully-namespaced resource name as an 
	 * argument.  It will check that the namespace for the resource is within 
	 * its remit.  If it is then it will attempt to load the resource.  
	 * Otherwise, it will return false and leave autoloading of the resource up 
	 * to some other autoloader in the queue.  
	 * 
	 * @param string $name The resource to load, including namespace
	 */
	protected function load ($name)
	{
		$found	= false;
		
		// Check that we should attempt to autoload
		if (($this -> isEnabled ())
		&& ($this -> inRemit ($name)))
		{
			$file	= $this -> calculatePath ($name);
			if (is_file ($file))
			{
				/*
				 * Include the file and report success
				 * 
				 * The reason we're going with include_once here is because if 
				 * we use require, there's a possibility that a class_exists 
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
	 * Register the autoload method with the SPL autoload queue
	 * 
	 * The optional $push parameter will determine whether the autoloader will 
	 * be added at the end of the autoload queue or at the start.  If false, 
	 * then the autoloader will be added at the end of the autoload queue, and
	 * will only be invoked if all autoloaders ahead of it have run and failed
	 * to load the requested class.  If true, the autoloader will be pushed to
	 * the front of the queue and will run before any other registered 
	 * autoloaders.  The default is false.  
	 * 
	 * @param boolean $push Whether or not to push the autoloader to the start of the autoload queue
	 * @return \gordian\reefknot\autoload\Autoloader
	 * @throws \RuntimeException Thrown if registration failed
	 */
	public function register ($push = false)
	{
		if (false === $this -> isRegistered ())
		{
			$this -> registered = spl_autoload_register (array ($this, 'load'), true, $push);
			if (false === $this -> isRegistered ())
			{
				throw new \RuntimeException ('Unable to register autoloader');
			}
		}
		
		return $this;
	}
	
	/**
	 * Unregister the autoload method from the SPL autoload queue
	 * 
	 * @return \gordian\reefknot\autoload\Autoloader
	 * @throws \RuntimeException Thrown if the autoloader couldn't be unregistered
	 */
	public function unregister ()
	{
		if (true === $this -> isRegistered ())
		{
			$this -> registered	= !spl_autoload_unregister (array ($this, 'load'));
			if (true === $this -> isRegistered ())
			{
				throw new \RuntimeException ('Unable to unregister autoloader');
			}
		}
		
		return $this;
	}
	
	/**
	 * Determine whether the autoloader is registered
	 * 
	 * @return boolean True if the autoloader is currently registered
	 */
	public function isRegistered ()
	{
		return $this -> registered;
	}
	
	/**
	 * Enable the autoloader
	 * 
	 * The enable/disable mechanism allows you to skip a particular autoloader
	 * without removing it from the autoload queue.  This is useful if you want
	 * to temporarially skip a particular autoloader, but don't want to change
	 * the autoloading order.  
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
	 * When disabled, the autoloader's load method will not attempt to resolve
	 * a class and will simply returns false immideately.  This means that 
	 * autoloading with this instance will be skipped.  
	 * 
	 * The enable/disable mechanism allows you to skip a particular autoloader
	 * without removing it from the autoload queue.  This is useful if you want
	 * to temporarially skip a particular autoloader, but don't want to change
	 * the autoloading order.  
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
	 * Note: This method will return true if the class currently isn't 
	 * registered to the autoload queue.  To actually function, an autoloader
	 * has to both be registered and enabled.  
	 * 
	 * @return boolean True if the autoloader is currently enabled
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
