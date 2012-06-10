<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\markup\widget\abstr;

use 
	gordian\reefknot\markup\widget\iface;

/**
 * (X)HTML Widget
 *
 * @author Gordon McVey
 * @link https://developer.mozilla.org/en/HTML/Global_attributes
 */
abstract class Widget implements iface\Widget
{
	const
		TYPE	= '';
	
	protected
		
		/**
		 * @var \DOMDocument 
		 */
		$dom	= NULL,
		
		/**
		 * @var \DOMElement 
		 */
		$node	= NULL;
	
	/**
	 *
	 * @return bool True if the DOM node has been initialized 
	 */
	protected function isInitialized ()
	{
		return $this -> node !== NULL;
	}
	
	/**
	 *
	 * @return \DOMElement 
	 */
	public function getNode ()
	{
		if ($this -> node === NULL)
		{
			$this -> node = new \DOMElement (static::TYPE);
			$this -> dom -> appendChild ($this -> node);
		}
		return $this -> node;
	}
	
	/**
	 *
	 * @param string $attrName
	 * @return string
	 * @throws \InvalidArgumentException 
	 */
	protected function getAttr ($attrName)
	{
		$val	= '';
		
		if (is_string ($attrName))
		{
			if ($this -> isInitialized ())
			{
				$val	= $this -> getNode () -> getAttribute ($attrName);
			}
		}
		else
		{
			throw new \InvalidArgumentException;
		}
		
		return $val;
		
	}
	
	/**
	 *
	 * @param string $attrName
	 * @param string $newVal
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 * @throws \InvalidArgumentException 
	 */
	protected function setAttr ($attrName, $newVal)
	{
		if (is_string ($attrName))
		{
			!empty ($newVal)?
				$this -> getNode () -> setAttribute ($attrName, $newVal):
				$this -> getNode () -> removeAttribute ($attrName);		
		}
		else
		{
			throw new \InvalidArgumentException;
		}
		
		return $this;
	}
	
	/**
	 * add an item to an attribute list
	 * 
	 * @param string $attrName
	 * @param string $newVal
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	protected function addToAttr ($attrName, $newVal)
	{
		$keyList	= $this -> getAttr ($attrName);
		
		// List attributes in HTML are space-separated
		$keyList	.= !empty ($keyList)?
			' ' . $newVal:
			$newVal;
		
		return $this -> setAttr ($attrName, $keyList);
	}
	
	/**
	 * Remove an item from an attribute list
	 * 
	 * @param type $attrName
	 * @param type $val 
	 */
	protected function removeFromAttr ($attrName, $val)
	{
		$attrList	= explode (' ', $this -> getAttr ($attrName));
		
		while (($attrIndex = array_search ($val, $attrList, true)) !== false)
		{
			unset ($attrList [$attrIndex]);
		}
		
		return $this -> setAttr ($attrName, implode (' ', $attrList));
	}
	
	/**
	 * Test that the given value exists within an attribute list
	 * 
	 * @param string $attrName
	 * @param string $val
	 * @return bool 
	 */
	protected function attrHasVal ($attrName, $val)
	{
		$attrList	= explode (' ', $this -> getAttr ($attrName));
		return in_array ($val, $attrList);
	}
	
	/**
	 * Get the accesskey attribute
	 * 
	 * The access key of a widget is a space-separated list of keys to bind to 
	 * an element.  The first key in the that exists on the user's keyboard will 
	 * activate the element. 
	 * @return string 
	 */
	public function getAccessKeys ()
	{
		return $this -> getAttr ('accesskey');
	}
	
	/**
	 * Get whether the element is in contenteditable mode.  
	 * 
	 * The contentteditable mode is not a boolean, as it can have 3 values; 
	 * true, false or inherit (meaning that content editable is set or not by 
	 * inheritence from the parent)
	 * 
	 * @return bool|NULL Boolean true or false, or NULL for inherit 
	 */
	public function getContentEditable ()
	{
		return $this -> getAttr ('contenteditable');
	}
	
	/**
	 * 
	 * @return string 
	 */
	public function getContextMenu ()
	{
		return $this -> getAttr ('contextmenu');
	}
	
	/**
	 *
	 * @return string 
	 */
	public function getDir ()
	{
		return $this -> getAttr ('dir');
	}
	
	/**
	 * Get whether or not the element is draggable
	 * 
	 * Deagability is not a boolean, as it can have 3 values; true, false and
	 * auto (the decision regarding dragability is up to the browser)
	 * 
	 * @return string|NULL String true, false or auto, or NULL for unset 
	 */
	public function getDraggable ()
	{
		return $this -> getAttr ('draggable');
	}
	
	/**
	 *
	 * @return string 
	 */
	public function getDropZone ()
	{
		return $this -> getAttr ('dropzone');
	}
	
	/**
	 * 
	 * @return bool 
	 */
	public function isHidden ()
	{
		return $this -> getAttr ('hidden') === 'hidden';
	}
	
	/**
	 * Get the element's ID
	 * 
	 * @return string 
	 */
	public function getId ()
	{
		return $this -> getAttr ('id');
	}
	
	/**
	 *
	 * @return string 
	 */
	public function getLang ()
	{
		return $this -> getAttr ('lang');
	}
	
	/**
	 * Get the element's spell check mode
	 * 
	 * The spellcheck element is not a boolean, as it can have 3 values; true,
	 * false, or unset.  If the value is unset then the behaviour is browser-
	 * defined, or it can be inherited from a parent element. 
	 * 
	 * @return bool|NULL true or false, or NULL if not defined
	 */
	public function isSpellChecked ()
	{
		$checked	= $this -> getAttr ('spellcheck');
		
		$checked	= !empty ($checked)?
			 $checked === 'true':
			NULL;
		
		return $checked;
	}
	
	/**
	 *
	 * @return string 
	 */
	public function getStyle ()
	{
		return $this -> getAttr ('style');
	}
	
	/**
	 *
	 * @return int 
	 */
	public function getTabIndex ()
	{
		return $this -> getAttr ('tabindex');
	}
	
	/**
	 * 
	 * @return string 
	 */
	public function getTitle ()
	{
		return $this -> getAttr ('title');
	}
	
	/**
	 * Set the element's ID
	 * 
	 * @param type $id
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setId ($id)
	{
		return $this -> setAttr ('id', $id);
	}
	
	/**
	 *
	 * @param string|array $keys
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setAccessKeys ($keys)
	{
		if (is_array ($keys))
		{
			$keys	= implode (' ', $keys);
		}
		
		return $this -> setAttr ('accesskey', $keys);
	}
	
	/**
	 *
	 * @param string $class
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function addClass ($class)
	{
		return $this -> addToAttr ('class', $class);
	}
	
	/**
	 *
	 * @return string 
	 */
	public function getClasses ()
	{
		return $this -> getAttr ('class');
	}
	
	/**
	 *
	 * @param string $class
	 * @return bool 
	 */
	public function hasClass ($class)
	{
		return $this -> attrHasVal ('class', $class);
	}

	/**
	 *
	 * @param string $class
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function removeClass ($class)
	{
		return $this -> removeFromAttr ('class', $class);
	}
	
	/**
	 *
	 * @param array|string $classes
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setClasses ($classes)
	{
		if (is_array ($classes))
		{
			$classes	= implode (' ', $classes);
		}
		
		return $this -> setAttr ('class', $classes);
	}
	
	/**
	 *
	 * @param bool|string $state
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setContentEditable ($state)
	{
		if (is_bool ($state))
		{
			$state	= $state? 'true': 'false';
		}
		return $this -> setAttr ('contenteditable', $state);
	}
	
	/**
	 *
	 * @param string $contextMenu
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setContextMenu ($contextMenu)
	{
		return $this -> setAttr ('contextmenu', $contextMenu);
	}
	
	/**
	 *
	 * @param string $dir
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setDir ($dir)
	{
		return $this -> setAttr ('dir', $dir);
	}
	
	/**
	 *
	 * @param type $draggable
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setDraggable ($draggable)
	{
		if (is_bool ($draggable))
		{
			$draggable	= $draggable? 'true': 'false';
		}
		return $this -> setAttr ('draggable', $draggable);
	}
	
	/**
	 *
	 * @param type $dropZone
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setDropZone ($dropZone)
	{
		return $this -> setAttr ('dropzone', $dropZone);
	}
	
	/**
	 *
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setHidden ()
	{
		return $this -> setAttr ('hidden', 'hidden');
	}
	
	/**
	 *
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function unsetHidden ()
	{
		return $this -> setAttr ('hidden', NULL);
	}
	
	/**
	 * Turn on spell checking for this element
	 * 
	 * @param type $lang
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setLang ($lang)
	{
		return $this -> setAttr ('lang', $lang);
	}
	
	/**
	 * Explicitly turn off spell checking for this element
	 * 
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setSpellCheck ()
	{
		return $this -> setAttr ('spellcheck', 'true');
	}
	
	/**
	 * Revert spell checking behaviour to the default defined by the browser
	 * 
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function unsetSpellCheck ()
	{
		return $this -> setAttr ('spellcheck', 'false');
	}
	
	/**
	 *
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function resetSpellCheck ()
	{
		return $this -> setAttr ('spellcheck', NULL);
	}
	
	/**
	 *
	 * @param string $style
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setStyle ($style)
	{
		return $this -> setattr ('style', $style);
	}
	
	/**
	 *
	 * @param type $tabIndex
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setTabIndex ($tabIndex)
	{
		return $this -> setAttr ('tabindex', $tabIndex);
	}
	
	/**
	 *
	 * @param type $title
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setTitle ($title)
	{
		return $this -> setAttr ('title', $title);
	}
	
	/**
	 * Append a new access key to the accesskey list
	 * 
	 * @param string $key
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function addAccessKey ($key)
	{
		return $this -> addToAttr ('accesskey', $key);
	}

	/**
	 * Test to see if the specified access key has been set
	 * 
	 * @param string $key
	 * @return bool 
	 */
	public function hasAccessKey ($key)
	{
		return $this -> attrHasVal ('accesskey', $key);
	}
	
	/**
	 *
	 * @param string $key
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function removeAccessKey ($key)
	{
		return $this -> removeFromAttr ('accesskey', $key);
	}
		
	/**
	 *
	 * @param \DOMDocument $dom 
	 */
	public function __construct (\DOMDocument $dom)
	{
		$this -> dom	= $dom;
	}
	
	/**
	 *
	 * @return string 
	 */
	public function __toString ()
	{
		return $this -> dom -> saveHTML ($this -> getNode ());		
	}

}

