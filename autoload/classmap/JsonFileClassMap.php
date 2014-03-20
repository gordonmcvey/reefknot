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
	public function load ()
	{
		$raw	= $this -> loadRaw ();
		if ("" !== $raw)
		{
			if (NULL === ($parsed = json_decode ($raw, true)))
			{
				throw new \RuntimeException ("Failed to parse class map file {$this -> getFileName ()}");
			}
		}
		else
		{
			$parsed	= [];
		}

		return $this -> populate ($parsed);
	}

	/**
	 * @return $this
	 * @throws \RuntimeException
	 */
	public function save ()
	{
		return $this -> saveRaw (json_encode ($this -> getAll ()));
	}
}
