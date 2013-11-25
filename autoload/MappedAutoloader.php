<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload;

use gordian\reefknot\autoload\classmap\iface\ClassMap;

/**
 * Class-mapped autoloader
 *
 * This is an extension of the standard autoloader that utilises a ClassMap 
 * instance for faster resource - path resolution
 * 
 * In theory, using a class map should result in faster autoloading than
 * techniques that involve string manipulation of resource names to map them to 
 * a path.  
 * 
 * If the class isn't in the class map then the standard class-resolution 
 * mechanism will be used as a fallback.
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Autoload
 */
class MappedAutoloader extends Autoloader
{
	/**
	 * A map of resources to paths.
	 *
	 * @var ClassMap
	 */
	private	$classMap		= NULL;

	/**
	 * Flag determining whether autopopulation should take place
	 *
	 * @var bool
	 */
	private	$autoPopulate	= false;

	/**
	 * Get the current class map
	 *
	 * The class map consists of an associative array where the key is the
	 * namespaced resource name, and the value is the path to that resource.
	 *
	 * You an use this method in conjunction with auto-populate mode to build
	 * new class maps from scratch.  After autoloading resources you can export
	 * the current class map and store it for later use.
	 *
	 * @return \gordian\reefknot\autoload\classmap\iface\ClassMap
	 */
	public function getClassMap ()
	{
		return $this -> classMap;
	}
	
	/**
	 * Set a class map for the autoloader
	 *
	 * @param \gordian\reefknot\autoload\classmap\iface\ClassMap $classMap
	 * @return $this
	 */
	public function setClassMap (ClassMap $classMap)
	{
		$this -> classMap	= $classMap;
		return $this;
	}

	/**
	 * Enable auto-population mode
	 *
	 * @return $this
	 */
	public function enableAutoPopulate ()
	{
		$this -> autoPopulate	= true;
		return $this;
	}

	/**
	 * Disable auto-population mode
	 *
	 * @return $this
	 */
	public function disableAutoPopulate ()
	{
		$this -> autoPopulate	= false;
		return $this;
	}

	/**
	 * Determine whether the class map is in auto-population mode
	 *
	 * @return boolean
	 */
	public function isAutoPopulateEnabled ()
	{
		return $this -> autoPopulate;
	}

	/**
	 * Calculate the path from a namespaced resource name
	 * 
	 * This method attempts to find the path to the specified resource in the 
	 * class map.  If it doesn't find it then it will fallback onto the normal
	 * resource resolution method.  
	 * 
	 * If automatic populating of the class map is enabled then this method will
	 * add items to the class map as they are discovered.
	 * 
	 * @param string $name
	 * @return string
	 */
	protected function calculatePath ($name)
	{
		if (is_null ($path = $this -> classMap -> getPath ($name)))
		{
			// The class isn't in the map so fall back to the normal resolution method
			$path	= parent::calculatePath ($name);
			if ($this -> isAutoPopulateEnabled ())
			{
				$this -> classMap -> addPath ($name, $path);
			}
		}
		
		return $path;
	}
}
