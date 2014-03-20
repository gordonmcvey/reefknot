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
 * 
 * This class implements a persistant class map that uses a .ini file for
 * storage. 
 * 
 * @package gordian\reefknot\autoload\classmap
 */
class IniFileClassMap extends abstr\FileClassMap {

	const FILE_HEADER	= "; Reefknot class map INI file\n; Generated on: ";
		
	/**
	 * Load class map from an .ini file
	 * 
	 * @return $this
	 * @throws \RuntimeException
	 */
	public function load ()
	{
		// Disable warning level messages while reading the ini file
		$prevLevel	= error_reporting ();
		error_reporting ($prevLevel & (~E_WARNING));
		
		try {
			// Parse loaded file
			$classMap	= parse_ini_string ($this -> loadRaw ());
		} finally {
			// Restore previous error_reporting mode
			error_reporting ($prevLevel);
		}
		
		if ((is_null ($classMap)) || (false === $classMap)) {
			$lastErr	= error_get_last ();
			$fileName	= $this -> getFileName ();
			throw new \RuntimeException ("Failed to parse class map file $fileName. Error message: '$lastErr[message]'");
		}
		
		return $this -> populate ($classMap);
	}

	/**
	 * Save class map as an .ini file
	 * 
	 * @return $this
	 * @throws \RuntimeException
	 */
	public function save ()
	{
		return $this -> saveRaw ($this -> buildIniFileData ());
	}
	
	/**
	 * Generate a string of valid .ini file data
	 *
	 * @return string
	 */
	private function buildIniFileData ()
	{
		$iniFileData	= static::FILE_HEADER 
						. date (static::FILE_DATE_FORMAT)
						. PHP_EOL 
						. PHP_EOL;

		foreach ($this -> getAll () as $class => $path)
		{
			$iniFileData	.= "$class\t= '$path'" . PHP_EOL;
		}

		return $iniFileData;
	}
}
