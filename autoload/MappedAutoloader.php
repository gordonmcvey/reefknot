<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload;

/**
 * Class-mapped autoloader
 *
 * This is an extension of the standard autoloader that includes a lookup table
 * for faster resource - file resolution.  
 * 
 * In theory, using a classmap can result in faster autoloading than techniques
 * that involve string manipulation of resource names to map them to a path.  
 * 
 * If the class isn't in the class map then the standard class-resolution 
 * mechanism will be used as a fallback.
 * 
 * While we call it a classmap, it should be noted that it can contain lookup
 * references for all autoloadable resources, including interfaces and traits as 
 * well. 
 * 
 * @author Gordon McVey
 */
class MappedAutoloader extends Autoloader
{
	private
		
		/**
		 * A map of resources to paths.  
		 * 
		 * This is an associative array where the keys represent namespaced 
		 * resources and the values are the paths to those resources
		 * 
		 * @var array
		 */
		$classMap		= array (),
		
		/**
		 * Autopopulate flag
		 * 
		 * When true, the autoloader will add any resources it doesn't find in 
		 * the classmap automatically.  You can use this mode to automatically
		 * build a classmap by autoloading classes as normal, and exporting 
		 * the classmap at the end of the run so you can store it for future 
		 * use. 
		 * 
		 * @var boolean
		 */
		$autoPopulate	= true;
	
	/**
	 * Set a classmap up for the autoloader
	 * 
	 * This method allows you to preload the autoloader with a classmap.  The
	 * classmap consists of an associative array where the key is the namespaced
	 * resource name, and the value is the path to that resource.  
	 * 
	 * @param array $classMap
	 * @return \gordian\reefknot\autoload\MappedAutoloader
	 */
	public function setClassMap (array $classMap)
	{
		$this -> classMap	= $classMap;
		return $this;
	}
	
	/**
	 * Get the current classmap
	 * 
	 * The classmap consists of an associative array where the key is the 
	 * namespaced resource name, and the value is the path to that resource.  
	 * 
	 * You an use this method in conjunction with auto-populate mode to build 
	 * new clasmaps from scratch.  After autoloading resources you can export 
	 * the current classmap and store it for later use. 
	 * 
	 * @return array
	 */
	public function getClassMap ()
	{
		return $this -> classMap;
	}
	
	/**
	 * Enable classmap auto-populate mode
	 * 
	 * In auto-populate mode, the autoloader will store resources that aren't
	 * already in the classmap.  This is useful for building classmaps from 
	 * scratch.
	 * 
	 * @return \gordian\reefknot\autoload\MappedAutoloader
	 */
	public function enableAutoPopulate ()
	{
		$this -> autoPopulate	= true;
		return $this;
	}
	
	/**
	 * Disable classmap auto-populate mode 
	 * 
	 * @return \gordian\reefknot\autoload\MappedAutoloader
	 */
	public function disableAutoPopulate ()
	{
		$this -> autoPopulate	= false;
		return $this;
	}
	
	/**
	 * Calculate the path from a namespaced resource name
	 * 
	 * This method attempts to find the path to the specified resource in the 
	 * classmap.  If it doesn't find it then it will fallback onto the normal
	 * resource resolution method.  
	 * 
	 * If automatic populating of the classmap is enabled then this method will
	 * add items to the classmap as they are discovered.  
	 * 
	 * @param string $name
	 * @return string
	 */
	protected function calculatePath ($name)
	{
		if (is_null ($path = $this -> getPath ($name)))
		{
			$path	= parent::calculatePath ($name);
			if ($this -> autoPopulate)
			{
				$this -> addPath ($name, $path);
			}
		}
		
		return $path;
	}
	
	/**
	 * Add a path to the classmap
	 * 
	 * @param string $name The namespaced resource to map
	 * @param string $path The path to map the resource to
	 * @return \gordian\reefknot\autoload\MappedAutoloader
	 */
	protected function addPath ($name, $path)
	{
		$this -> classMap [$name]	= $path;
		return $this;
	}
	
	/**
	 * Get the path for the given resource 
	 * 
	 * @param string $name
	 * @return string
	 */
	protected function getPath ($name)
	{
		return isset ($this -> classMap [$name])? 
				$this -> classMap [$name]: 
				NULL;
	}
}
