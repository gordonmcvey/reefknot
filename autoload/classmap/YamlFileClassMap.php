<?php
/**
 * Reefknot framework
 *
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload\classmap;

/**
 * Class YamlFileClassMap
 *
 * This class implements the file class map to use a YAML file.
 *
 * @package gordian\reefknot\autoload\classmap
 */
class YamlFileClassMap extends abstr\FileClassMap {

	public function load ()
	{
		// TODO: Implement load() method.
	}

	public function save ()
	{
		// TODO: Implement save() method.
	}

	public function __construct () {
		if (!extension_loaded ('yaml')) {
			throw new \RuntimeException ("This class requires the YAML extension");
		}
	}
}
