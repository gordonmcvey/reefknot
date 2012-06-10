<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\markup\widget\iface;

/**
 *
 * @author Gordon McVey
 */
interface Widget
{
	public function addAccessKey ($key);
	public function addClass ($class);
	public function getAccessKeys ();
	public function getContentEditable ();
	public function getContextMenu ();
	public function getClasses ();
	public function getDir ();
	public function getDraggable ();
	public function getDropZone ();
	public function getId ();
	public function getLang ();
	public function getNode ();
	public function getStyle ();
	public function getTabIndex ();
	public function getTitle ();
	public function hasAccessKey ($key);
	public function hasClass ($class);
	public function isHidden ();
	public function isSpellChecked ();
	public function removeAccessKey ($key);
	public function removeClass ($class);
	public function resetSpellCheck ();
	public function setAccessKeys ($keys);
	public function setClasses ($classes);
	public function setContentEditable ($state);
	public function setContextMenu ($contextMenu);
	public function setDir ($dir);
	public function setDraggable ($draggable);
	public function setDropZone ($dropZone);
	public function setHidden ();
	public function setId ($id);
	public function setLang ($lang);
	public function setSpellCheck ();
	public function setStyle ($style);
	public function setTabIndex ($tabIndex);
	public function setTitle ($title);
	public function unsetHidden ();
	public function unsetSpellCheck ();
	public function __toString ();
}
