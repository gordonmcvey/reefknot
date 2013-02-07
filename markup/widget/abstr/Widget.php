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
 * @todo Implement HTML5 data-* attribute management
 */
abstract class Widget implements iface\Widget
{
	protected
				
		/**
		 * @var \DOMDocument 
		 */
		$dom		= NULL,
		
		/**
		 * @var \DOMElement 
		 */
		$node		= NULL;
	
	/**
	 * Determine if we've initialized the DOM node
	 * 
	 * @return bool True if the DOM node has been initialized 
	 */
	protected function isInitialized ()
	{
		return $this -> node !== NULL;
	}
	
	/**
	 * Get the DOM node
	 * 
	 * @return \DOMElement 
	 */
	public function getNode ()
	{
		$elemType	= $this -> getElemType ();
		if ($elemType !== '')
		{
			// Do lazy node initialization
			if (!$this -> isInitialized ())
			{
				$this -> node = new \DOMElement ($elemType);
				$this -> dom -> appendChild ($this -> node);
			}
		}
		else
		{
			// We can't generate a node if an element type hasn't been specified
			throw new \BadMethodCallException (__METHOD__ . ': No element type defined');
		}
		
		return $this -> node;
	}
	
	/**
	 * Return the value of the named element attribute (if it exists)
	 *
	 * @param string $attrName
	 * @return string The attribute value (or an empty string if it isn't set)
	 * @throws \InvalidArgumentException 
	 */
	protected function getAttr ($attrName)
	{
		$attrValue	= '';
		
		if (is_string ($attrName))
		{
			if ($this -> isInitialized ())
			{
				$attrValue	= $this -> getNode () -> getAttribute ($attrName);
			}
		}
		else
		{
			// Attribute name is invalid
			throw new \InvalidArgumentException (__METHOD__ 
												. ': Attribute name must be a string, ' 
												. gettype ($attrName) 
												. 'given');
		}
		
		return $attrValue;
	}
	
	/**
	 * Set the named element attribute to the given value
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
	 * @param string $attrName
	 * @param string $val 
	 * @return \gordian\reefknot\markup\widget\abstr\Widget
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
	 * 
	 * @return string 
	 * @link http://www.whatwg.org/specs/web-apps/current-work/multipage/editing.html#the-accesskey-attribute
	 */
	public function getAccessKeys ()
	{
		return $this -> getAttr ('accesskey');
	}
	
	/**
	 * Set the elements accesskey list
	 * 
	 * @param string|array $keys
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 * @link http://www.whatwg.org/specs/web-apps/current-work/multipage/editing.html#the-accesskey-attribute
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
	 * Append a new access key to the accesskey list
	 * 
	 * @param string $key
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 * @link http://www.whatwg.org/specs/web-apps/current-work/multipage/editing.html#the-accesskey-attribute
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
	 * @link http://www.whatwg.org/specs/web-apps/current-work/multipage/editing.html#the-accesskey-attribute
	 */
	public function hasAccessKey ($key)
	{
		return $this -> attrHasVal ('accesskey', $key);
	}
	
	/**
	 * Remove the specified access key from the access key list
	 * 
	 * @param string $key
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 * @link http://www.whatwg.org/specs/web-apps/current-work/multipage/editing.html#the-accesskey-attribute
	 */
	public function removeAccessKey ($key)
	{
		return $this -> removeFromAttr ('accesskey', $key);
	}
		
	/**
	 * Get whether the element is in contenteditable mode.  
	 * 
	 * The contentteditable mode is not a boolean, as it can have 3 values; 
	 * true, false or inherit (meaning that content editable is set or not by 
	 * inheritence from the parent)
	 * 
	 * @return bool|NULL Boolean true or false, or NULL for inherit 
	 * @link http://www.whatwg.org/specs/web-apps/current-work/multipage/editing.html#attr-contenteditable
	 */
	public function getContentEditable ()
	{
		return $this -> getAttr ('contenteditable');
	}
	
	/**
	 * Set the contenteditable attribute to the specified value
	 * 
	 * @param bool|string $state Must be one of true, false, inherit, or an empty value
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 * @throws \InvalidArgumentException 
	 * @link http://www.whatwg.org/specs/web-apps/current-work/multipage/editing.html#attr-contenteditable
	 */
	public function setContentEditable ($state)
	{
		if (is_bool ($state))
		{
			$state	= $state? 'true': 'false';
		}
		
		if (($state === 'true')
		|| ($state === 'false')
		|| ($state === 'inherit')
		|| (empty ($state)))
		{
			return $this -> setAttr ('contenteditable', $state);
		}
		else
		{
			throw new \InvalidArgumentException;
		}
	}
	
	/**
	 * Set the ID of the context menu to associate with this element
	 * 
	 * @return string 
	 * @link http://www.whatwg.org/specs/web-apps/current-work/multipage/interactive-elements.html#context-menus
	 */
	public function getContextMenu ()
	{
		return $this -> getAttr ('contextmenu');
	}
	
	/**
	 * Get the current context menu ID
	 * 
	 * @param string $contextMenu
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 * @link http://www.whatwg.org/specs/web-apps/current-work/multipage/interactive-elements.html#context-menus
	 */
	public function setContextMenu ($contextMenu)
	{
		return $this -> setAttr ('contextmenu', $contextMenu);
	}
	
	/**
	 * Get the directionality attribute of the element
	 * 
	 * @return string 
	 */
	public function getDir ()
	{
		return $this -> getAttr ('dir');
	}
	
	/**
	 * Set the directionality of the element
	 * 
	 * @param string $dir Must be one of ltr, rtl, auto or an empty value
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 */
	public function setDir ($dir)
	{
		if (($dir === 'ltr')
		|| ($dir === 'rtl')
		|| ($dir === 'auto')
		|| (empty ($dir)))
		{
			return $this -> setAttr ('dir', $dir);
		}
		else
		{
			throw new \InvalidArgumentException;
		}
	}
	
	/**
	 * Get whether or not the element is draggable
	 * 
	 * Deagability is not a boolean, as it can have 3 values; true, false and
	 * auto (the decision regarding dragability is up to the browser)
	 * 
	 * @return string|NULL String true, false or auto, or NULL for unset 
	 * @link http://www.whatwg.org/specs/web-apps/current-work/multipage/dnd.html#the-draggable-attribute
	 */
	public function getDraggable ()
	{
		return $this -> getAttr ('draggable');
	}
	
	/**
	 *
	 * @param type $draggable
	 * @return \gordian\reefknot\markup\widget\abstr\Widget 
	 * @link http://www.whatwg.org/specs/web-apps/current-work/multipage/dnd.html#the-draggable-attribute	
	 */
	public function setDraggable ($draggable)
	{
		if (is_bool ($draggable))
		{
			$draggable	= $draggable? 'true': 'false';
		}
		return $this -> setAttr ('draggable', $draggable);
	}
	
	public function unsetDraggable ()
	{
		
	}
	
	public function resetDraggable ()
	{
		
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

