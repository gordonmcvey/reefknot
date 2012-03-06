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
 * You can reuse this autoloader in your own projects by subclassing it and 
 * replacing the values of the class constants.  You should be able to subclass 
 * this autoloader for any class structure that utilises a simple 1:1 mapping 
 * of a namespace structure to a directory structure. 
 */
class Autoload implements iface\Autoload
{
	const
	
		/**
		 * Shortcut to the DIRECTORY_SEPARATOR PHP constant 
		 */
		DS				= \gordian\reefknot\DS;
	
	protected
		
		/**
		 * Character to use as the namespace separator. Defaults to '\'
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
		 * Flag to determine if this instance of the autoloader has been registered
		 * 
		 * @var bool 
		 */
		$registered		= false;
	
	/**
	 * Autoloader for the framework
	 * 
	 * This autoloader method determines if the requested class is part of the 
	 * framework.  If it is, it will be included.  Otherwise, it will be up to
	 * another SPL autoloader to handle loading the requested class
	 * 
	 * @param string $name The class to load, including namespace
	 */
	protected function load ($name)
	{
		$found	= false;
		
		/* 
		 * We only want to use this autoloader on classes that are within the 
		 * specified namespace and use the correct namespace separator
		 */
		if ((strpos ($name, $this -> namespaceSep) !== false)
		&& (strpos ($name, $this -> namespaceRoot) === 0))
		{
			// Calculate the file path
			$file	= $this -> pathRoot 
					. str_replace ($this -> namespaceSep, static::DS, str_replace ($this -> namespaceRoot, '', $name)) 
					. $this -> fileSuffix;
			// Include the file if it exists and report success
			if (is_file ($file))
			{
				include_once ($file);
				// We only want to return true if the class/interface we tried to autoload now exists
				$found	= class_exists ($name, false) 
						|| interface_exists ($name, false);
			}
		}
		
		return ($found);
	}
	
	/**
	 * Register the autoload method with the SPL autoload stack
	 * 
	 * @return bool True if the autoloader was registered successfully
	 */
	public function register ()
	{
		if (!$this -> registered)
		{
			$this -> registered = spl_autoload_register (array ($this, 'load'));
		}
		return ($this -> registered);
	}
	
	/**
	 * Unregister the autoload method from the SPL autoload stack
	 * 
	 * @return bool True is the autoloader was unregistered successfully
	 */
	public function unregister ()
	{
		if ($this -> registered)
		{
			$this -> registered	= !spl_autoload_unregister (array ($this, 'load'));
		}
		return (!$this -> registered);
	}
	
	/**
	 * Initialize the autoloader
	 * 
	 * @param string $path The root path for class files
	 * @param string $namespace The namespace within which the autoloader will operate
	 * @param string $seperator The character(s) to treat as the namespace separator
	 * @param string $suffix The file suffix to expect for classes
	 */
	public function __construct (	$path = \gordian\reefknot\PATH_FW, 
									$namespace = \gordian\reefknot\NS_FW, 
									$seperator = \gordian\reefknot\NS_SEP, 
									$suffix = '.php')
	{
		// Set custom namespace props
		$this -> namespaceSep	= $seperator;
		$this -> namespaceRoot	= $namespace;
		$this -> pathRoot		= $path;
		$this -> fileSuffix		= $suffix;
		
		// Add this instance of the autoloader to the SPL autoload stack
		$this -> register ();
	}
	
	public function __destruct ()
	{
		$this -> unregister ();
	}
}
