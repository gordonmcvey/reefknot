<?php
/**
 * Reefknot framework
 *
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload\classmap\abstr;

use gordian\reefknot as rf,
	gordian\reefknot\autoload\classmap\iface;

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
	 * It's up to the subclass to implement a decoding strategy for the raw data
	 *
	 * @return string The raw data from the file
	 * @throws \RuntimeException
	 */
	protected function loadRaw () {
		$fileName	= $this -> getFileName ();

		if (false === ($raw = file_get_contents ($fileName))) {
			throw new \RuntimeException ("Failed to load class map file '$fileName'");
		}

		return $raw;
	}

	/**
	 * Load the class map
	 *
	 * @return $this
	 * @throws \RuntimeException
	 */
	abstract protected function load ();

	/**
	 * Save the class map
	 *
	 * @return $this
	 * @throws /RuntimeException
	 */
	abstract protected function save ();

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
			// If the file already exists and is writable then return its path
			if (($fullPath = realpath ($unvalidatedPath))
			&& (is_file ($fullPath))
			&& (is_writable ($fullPath))) {
				$validatedPath	= $fullPath;
			} else
			// If the file isn't valid, but its parent directory exists, is
			// writable and doesn't contain an invalid file of the given name
			// then return the file's path with the filename appended.
			if ((!$fullPath)
			&& ($dirPath = realpath (dirname ($unvalidatedPath)))
			&& (is_dir ($dirPath))
			&& (is_writable ($dirPath))) {
				$validatedPath	= $dirPath . rf\DS . basename ($unvalidatedPath);
			}
		}

		return $validatedPath;
	}

	/**
	 * Do automatic autosave on shutdown if it's enabled
	 */
	public function __destruct () {
		if ($this -> autoSave) {
			try {
				$this -> save ();
			} catch (\Exception $e) {
				// You can't allow exceptions to propagate from destructors
				error_log ($e -> getMessage ());
				error_log ($e -> getTraceAsString ());
			}
		}
	}
}
