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
		$raw	= $this -> loadRaw ();
		if ('' !== $raw)
		{
			// Disable warning level messages while reading the ini file
			$prevLevel	= error_reporting ();
			error_reporting ($prevLevel & (~E_NOTICE));

			// Parse loaded file
			$parsed	= unserialize ($raw);

			// Restore previous error_reporting mode
			error_reporting ($prevLevel);

			if (FALSE === $parsed)
			{
				$lastErr	= error_get_last ();
				throw new \RuntimeException ("Failed to parse class map file '{$this -> getFileName ()}'. Error message: '$lastErr[message]'");
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
		return $this -> saveRaw (serialize ($this -> getAll ()));
	}
}
