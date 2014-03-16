<?php
/**
 * Reefknot framework
 *
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload\classmap;

/**
 * Class SerializedFileClassMap
 * @package gordian\reefknot\autoload\classmap
 */
class SerializedFileClassMap extends abstr\FileClassMap {

	/**
	 * @return $this
	 * @throws \RuntimeException
	 */
	public function load ()
	{
		if (false === ($parsed = @unserialize ($this -> loadRaw()))) {
			throw new \RuntimeException ("Failed to parse class map file {$this -> getFileName ()}");
		}

		return $this -> populate ($parsed);
	}

	/**
	 * @return $this
	 * @throws \RuntimeException
	 */
	public function save ()
	{
		$fileName	= $this -> getFileName ();

		if (false === file_put_contents ($fileName, serialize ($this -> getAll ()), LOCK_EX)) {
			throw new \RuntimeException ("Failed to write class map file $fileName");
		}

		return $this;
	}
}
