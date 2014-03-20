<?php // @codeCoverageIgnoreStart
/**
 * Reefknot framework
 *
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\autoload\classmap\iface;

interface FileClassMap extends ClassMap {

	/**
	 * Get the current filename
	 *
	 * @return string
	 */
	public function getFileName ();

	/**
	 * @param string $fileName
	 * @return $this
	 * @throws \InvalidArgumentException
	 */
	public function setFileName ($fileName);

	/**
	 * Return whether or not autosaving is enabled
	 *
	 * @return bool
	 */
	public function isAutoSaveEnabled ();

	/**
	 * Turn on autosave
	 *
	 * @return $this
	 */
	public function enableAutoSave ();

	/**
	 * Turn off autosave
	 *
	 * @return $this
	 */
	public function disableAutoSave ();

	/**
	 * Load the class map file
	 *
	 * @return $this
	 * @throws \RuntimeException
	 */
	public function load ();

	/**
	 * Save the class map file
	 *
	 * @return $this
	 * @throws \RuntimeException
	 */
	public function save ();
}
