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
	
	private $exLock		= true;
	
	/**
	 * Load class map from an .ini file
	 * 
	 * @return $this
	 * @throws \RuntimeException
	 */
	public function load ()
	{
		$fileName	= $this -> getFileName ();
		
		// Disable warning level messages while reading the ini file
		$currentLevel	= error_reporting ();		
		error_reporting ($currentLevel ^ E_WARNING);
		
		// Load file
		$failed	= false === ($classMap = parse_ini_file ($fileName));
		
		// Restore previous error_reporting mode
		error_reporting ($currentLevel);
		if ($failed) {
			$lastErr	= error_get_last ();
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
		$fileName	= $this -> getFileName ();
		
		// Disable warning level messages while reading the ini file
		$currentLevel	= error_reporting ();		
		error_reporting ($currentLevel ^ E_WARNING);
		
		// Load file
		$failed	= false === file_put_contents ($fileName, $this -> buildIniFileData (), ($this -> exLock? LOCK_EX: 0));
		
		// Restore previous error_reporting mode
		error_reporting ($currentLevel);

		if ($failed) {
			$lastErr	= error_get_last ();
			throw new \RuntimeException ("Failed to write class map file $fileName. Error message: '$lastErr[message]'");
		}

		return $this;
	}
	
	public function disableTest () {
		$this -> exLock	= TRUE;
		return $this;
	}
	
	public function enableTest () {
		$this -> exLock	= FALSE;
		return $this;
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
