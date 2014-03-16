<?php
/**
 * Reefknot framework
 *
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload\classmap\iface;

/**
 * Class Map interface
 *
 * This interface describes the standard API for class maps
 *
 * While we're calling it a class map, it should be noted that it can contain
 * references for all autoloadable resources, including interfaces and traits as
 * well.  A more correct name would be something such as AutoloadableResourceMap
 * but ClassMap is easier to work with.
 *
 * @author Gordon McVey
 * @package gordian\reefknot\autoload\classmap\iface
 */
interface ClassMap {

	/**
	 * Look up the path for the given class/interface/trait
	 *
	 * @param string $class
	 * @return string
	 */
	public function getMapping ($class);

	/**
	 * Add a path to the class map
	 *
	 * @param string $class The namespaced resource to map
	 * @param string $path The path to map the resource to
	 * @return ClassMap
	 */
	public function addMapping ($class, $path);

	/**
	 * Remote the specified class map entry
	 *
	 * @param string $class
	 * @return ClassMap
	 */
	public function removeMapping ($class);

	/**
	 * Get all mappings currently in the class map
	 *
	 * @return array
	 */
	public function getAll ();
}
