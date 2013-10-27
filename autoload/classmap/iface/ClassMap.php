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
 * This interface describes the standard API for classmaps
 * 
 * While we're calling it a classmap, it should be noted that it can contain 
 * references for all autoloadable resources, including interfaces and traits as 
 * well.  A more correct name would be something such as AutoloadableResourceMap
 * but ClassMap is easier to work with.  
 * 
 * @author Gordon McVey
 */
interface ClassMap {
	//put your code here
	
	/**
	 * Look up the path for the given class/interface/trait
	 * 
	 * @param string $class
	 * @return string
	 */
	public function getPath ($class);
	
	/**
	 * Add a path to the classmap
	 * 
	 * @param string $class The namespaced resource to map
	 * @param string $path The path to map the resource to
	 * @return ClassMap
	 */
	public function addPath ($class, $path);
	
	/**
	 * Remote the specified class map entry
	 * 
	 * @param string $class
	 * @return ClassMap
	 */
	public function removePath ($class);
}
