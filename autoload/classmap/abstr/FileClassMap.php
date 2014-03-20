<?php
/**
 * Reefknot framework
 *
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload\classmap\abstr;

use gordian\reefknot\autoload\classmap\iface;

/**
 * Class FileClassMap
 *
 * A FileClassMap is a persistent class map that uses a physical file as its
 * persistence mechanism.
 *
 * @package gordian\reefknot\autoload\classmap\abstr
 */
abstract class FileClassMap extends ClassMap implements iface\FileClassMap
{
	const FILE_DATE_FORMAT	= "c";

	/**
	 * The absolute path to the file to use for the class map
	 *
	 * @var string
	 */
	private $fileName	= '';

	/**
	 * Whether or not to automatically save the class map on shutdown
	 *
	 * @var bool
	 */
	private	$autoSave	= false;

	/**
	 * Get the current filename
	 *
	 * @return string
	 */
	public function getFileName ()
	{
		return $this -> fileName;
	}

	/**
	 * Set the path to the resource that will be used for classmap data
	 * 
	 * @param string $fileName
	 * @return $this
	 * @throws \InvalidArgumentException
	 */
	public function setFileName ($fileName)
	{
		if (NULL === ($validatedFileName = $this -> getValidatedPath ($fileName))) {
			throw new \InvalidArgumentException ("Given path '$fileName' is not valid");
		}

		$this -> fileName	= $validatedFileName;
		return $this;
	}

	/**
	 * Return whether or not autosaving is enabled
	 *
	 * @return bool
	 */
	public function isAutoSaveEnabled () {
		return $this -> autoSave;
	}

	/**
	 * Turn on autosave
	 *
	 * @return $this
	 */
	public function enableAutoSave () {
		$this -> autoSave	= true;
		return $this;
	}

	/**
	 * Turn off autosave
	 *
	 * @return $this
	 */
	public function disableAutoSave () {
		$this -> autoSave	= false;
		return $this;
	}

	/**
	 * Load the raw data for the class map
	 *
	 * This is a simple helper method for subclasses that loads the content of 
	 * the specified classmap file without attempting to parse it.  It's up to 
	 * the subclass to implement a decoding strategy for the raw data
	 *
	 * @return string The raw data from the file
	 * @throws \RuntimeException
	 */
	protected function loadRaw ()
	{
		$fileName	= $this -> getFileName ();
		
		if (!$fileName)
		{
			throw new \RuntimeException ("No class map file specified");
		}
		
		// Disable warning level messages while reading the file
		$prevLevel	= error_reporting ();
		error_reporting ($prevLevel & (~E_WARNING));
		
		// Attempt to load file
		$raw = file_get_contents ($fileName);
		
		// Restore previous error_reporting level
		error_reporting ($prevLevel);
		
		// Check if we were successful
		if (false === ($raw))
		{
			$lastErr	= error_get_last ();
			throw new \RuntimeException ("Failed to load class map file '$fileName'. Error message: '$lastErr[message]'");
		}

		return $raw;
	}
	
	/**
	 * Save class map as an .ini file
	 * 
	 * @return $this
	 * @throws \RuntimeException
	 */
	protected function saveRaw ($raw) {
		$fileName	= $this -> getFileName ();
		
		// Disable warning level messages while writing the file
		$prevLevel	= error_reporting ();
		error_reporting ($prevLevel & (~E_WARNING));
		
		// Save file
		$written	= file_put_contents ($fileName, $raw, (LOCK_EX));
		
		// Restore previous error_reporting mode
		error_reporting ($prevLevel);

		if (false === $written) {
			$lastErr	= error_get_last ();
			throw new \RuntimeException ("Failed to write class map file $fileName. Error message: '$lastErr[message]'");
		}

		return $this;
	}
	
	/**
	 * Validate the given path
	 *
	 * A path if considered valid if it points to a writable file, or if its
	 * directory portion points to a writable directory that doesn't contain a
	 * child item of the given file name.  If the directory contains a child of
	 * the given name that isn't writable or isn't a file, or if the path is
	 * otherwise invalid then NULL is returned.
	 *
	 * @param $unvalidatedPath
	 * @return string|NULL
	 */
	private function getValidatedPath ($unvalidatedPath) {
		$validatedPath	= NULL;

		if (!empty ($unvalidatedPath)) {
			$unvalidatedPath	= $this -> getCanonicalPath ($unvalidatedPath);
			if (($this -> isFileAvailable ($unvalidatedPath)) 
				|| ((!file_exists ($unvalidatedPath)) 
					&& ($this -> isDirectoryAvailable (dirname ($unvalidatedPath))))) {
				$validatedPath	= $unvalidatedPath;
			}
		}

		return $validatedPath;
	}

	/**
	 * Attempt to normalise the given path to a canonical one
	 * 
	 * This methos tries to get a canonical path for the given one.  If it can't
	 * then it returns the original path.  
	 * 
	 * We want canonical paths when saving classmaps, but we can't get one for 
	 * items accessed through a file wrapper so we'll just leave it as is if we
	 * can't normalise it.  
	 * 
	 * @param string $rawPath
	 * @return string
	 */
	private function getCanonicalPath ($rawPath) {
		$canonicalPath	= realpath ($rawPath);
		if (false === $canonicalPath) {
			$canonicalPath	= $rawPath;
		}

		return $canonicalPath;
	}
	
	/**
	 * Check that the given filename exists and is writable
	 * 
	 * @param string $path
	 * @return boolean
	 */
	private function isFileAvailable ($path) {
		return is_file ($path) 
			&& is_readable ($path) 
			&& is_writable ($path);
	}
	
	/**
	 * Check that the given directory exists and is writable
	 * 
	 * @param string $path
	 * @return boolean
	 */
	private function isDirectoryAvailable ($path) {
		return is_dir ($path) 
			&& is_readable ($path) 
			&& is_writable ($path);
	}
	
	/**
	 * Do automatic save on shutdown if it's enabled
	 */
	public function __destruct () {
		if ($this -> autoSave) {
			try {
				$this -> save ();
			} catch (\Exception $e) {
				// You can't allow exceptions to propagate from destructors
				error_log ((string) $e);
			}
		}
	}
}
