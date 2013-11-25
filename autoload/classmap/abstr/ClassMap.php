<?php
/**
 * Reefknot framework
 *
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload\classmap\abstr;

use gordian\reefknot\autoload\classmap\iface;

/**
 * Class ClassMap
 *
 * This is a base implementation for the Class Map interface, it provides a
 * simple array-based implementation for other autoloaders to build on.
 *
 * @package gordian\reefknot\autoload\classmap\abstr
 * @author Gordon McVey
 */
abstract class ClassMap implements iface\ClassMap {

	/**
	 * The array that acts as the class map
	 *
	 * @var array
	 */
	private	$classMap	= array ();

	/**
	 * Get the path for the specified class/interface/trait
	 *
	 * This method returns the path to the namespaced class given in the
	 * argument.  If the given class isn't in the map then NULL is returned.
	 *
	 * @param string $class
	 * @return string
	 */
	public function getPath ($class)
	{
		return isset ($this -> classMap [$class])?
			$this -> classMap [$class]:
			NULL;
	}

	/**
	 * Add a path for the specified class/interface/trait
	 *
	 * @param string $class
	 * @param string $path
	 * @return \gordian\reefknot\autoload\classmap\ArrayClassMap
	 */
	public function addPath ($class, $path)
	{
		$this -> classMap [$class]	= $path;
		return $this;
	}

	/**
	 * Remove the specified class/interface/trait from the class map
	 *
	 *
	 * @param string $class
	 * @return \gordian\reefknot\autoload\classmap\ArrayClassMap
	 */
	public function removePath ($class)
	{
		if (isset ($this -> classMap [$class])) {
			unset ($this -> classMap [$class]);
		}

		return $this;
	}

	/**
	 * Remove all entries from the class map
	 *
	 * @return \gordian\reefknot\autoload\classmap\ArrayClassMap
	 */
	public function reset ()
	{
		$this -> classMap	= array ();
		return $this;
	}

	/**
	 * Populate the class map with an array of class keys and path values
	 *
	 * This method allows you to quickly populate the class map.  The $classMap
	 * parameter consists of an associative array where the key is the
	 * namespaced resource name, and the value is the path to that resource.
	 *
	 * @param array $classMap Associative array to use as data to populate the class map
	 * @return \gordian\reefknot\autoload\classmap\ArrayClassMap
	 */
	protected function populate (array $classMap)
	{
		$this -> classMap	= $classMap;
		return $this;
	}

	/**
	 * Get all mappings currently in the class map
	 *
	 * This method returns an associative array where the keys are the fully
	 * namespaced resources being mapped to and the values are the paths that
	 * the class map holds for the resources in question
	 *
	 * @return array
	 */
	public function getAll ()
	{
		return $this -> classMap;
	}
}
