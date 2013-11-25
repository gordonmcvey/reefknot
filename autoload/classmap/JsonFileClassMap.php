<?php
/**
 * Reefknot framework
 *
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload\classmap;

/**
 * Class JsonFileClassMap
 * @package gordian\reefknot\autoload\classmap
 */
class JsonFileClassMap extends abstr\FileClassMap {

	/**
	 * @return ArrayClassMap
	 * @throws \RuntimeException
	 */
	protected function load ()
	{
		if (NULL === ($parsed = json_decode ($this -> loadRaw (), true))) {
			throw new \RuntimeException ("Failed to parse class map file {$this -> getFileName ()}");
		}

		return $this -> populate ($parsed);
	}

	protected function save()
	{
		// TODO: Implement save() method.
	}
}
