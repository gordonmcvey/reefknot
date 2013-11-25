<?php
/**
 * Reefknot framework
 *
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload\classmap;

/**
 * Class IniFileClassMap
 * @package gordian\reefknot\autoload\classmap
 */
class IniFileClassMap extends abstr\FileClassMap {

	const FILE_HEADER	= "; Reefknot class map INI file";

	/**
	 * @return $this
	 * @throws \RuntimeException
	 */
	protected function load ()
	{
		$fileName	= $this -> getFileName ();

		if (false === ($classMap = parse_ini_file ($fileName))) {
			throw new \RuntimeException ("Failed to parse class map file $fileName");
		}

		return $this -> populate ($classMap);
	}

	/**
	 * @return $this
	 * @throws \RuntimeException
	 */
	protected function save ()
	{
		$fileName	= $this -> getFileName ();

		if (false === file_put_contents ($fileName, $this -> buildIniFileData (), LOCK_EX)) {
			throw new \RuntimeException ("Failed to write class map file $fileName");
		}

		return $this;
	}

	/**
	 * Generate a string of valid INI file data
	 *
	 * @return string
	 */
	private function buildIniFileData ()
	{
		$iniFileData	= static::FILE_HEADER . PHP_EOL . PHP_EOL;

		foreach ($this -> getAll () as $class => $path)
		{
			$iniFileData	.= "'$class'\t= '$path'" . PHP_EOL;
		}

		return $iniFileData;
	}
}
