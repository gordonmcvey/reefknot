<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload\classmap;

use gordian\reefknot\autoload\classmap\abstr\ClassMap;

/**
 * ClassMap implementation based around an array
 * 
 * This is about the simplest implementation of the ClassMap interface possible,
 * it uses an internal array to store class map entries.  
 * 
 * @author Gordon McVey
 * @package gordian\reefknot\autoload\classmap
 */
class ArrayClassMap extends ClassMap
{
	/**
	 * Initialize the class map
	 * 
	 * @param array $classMap
	 */
	public function __construct (array $classMap = array ())
	{
		$this -> populate ($classMap);
	}
}
