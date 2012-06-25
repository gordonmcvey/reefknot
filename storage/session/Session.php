<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\storage\session;

/**
 * Session management
 * 
 * Each instance of the Session object represents a "namespace" within the PHP
 * $_SESSION system.  This allows sessions to be easily managed and organized
 * within an application
 * 
 * WARNING: The underlying mechanism for the Session class is the PHP $_SESSION
 * system.  This means that the data that instances of this class manage can 
 * easily be mutated from outside.  It is strongly recommended that you take an
 * "all or nothing" approach when using this class. Either do all your session
 * management through Session objects, or do it all manually.  If you mix and
 * match then you might not get the results you expect.  
 * 
 * WARNING: It is possible for multiple Sessions with the same name to be 
 * instantized, and all instances will point to the same key in $_SESSION.  You
 * could in theory use this to have multiple access paths to the same state by
 * creating multiple instances with the same name.  However, this is NOT 
 * recommended, as it could easily lead to a great deal of confusion, and 
 * measures to prevent such use may be introduced in the future.  If you need 
 * the same session state in more than one place, then you are advised to pass
 * the same instance of the class to the objects that need it instead.  
 *
 * @todo implement Iterator interface
 * @author Gordon McVey
 * @category Reefknot
 * @package Storage
 * @subpackage Session
 */
class Session implements iface\Session
{
	
	protected
		
		/**
		 * @var iface\Binding 
		 */
		$binding	= NULL, 
		
		/**
		 * The 'namespace' for the session data.  Maps to $_SESSION [$namespace]
		 * 
		 * @var string
		 */
		$namespace	= '',
		
		/**
		 * The alias that this instance of the class will use to access the 
		 * session data.  
		 * 
		 * @var &array 
		 */
		$storage	= NULL;
	
	// -[ Countable implementation starts here ]--------------------------------
	
	/**
	 * Implementation of countable count
	 * 
	 * @return int 
	 */
	public function count ()
	{
		return count ($this -> storage);
	}
	
	// -[ Iterator implementation starts here ]---------------------------------
	
	/**
	 * Implementation of iterator rewind 
	 * 
	 * @return mixed
	 */
	public function rewind ()
	{
		return \reset ($this -> storage);
	}
	
	/**
	 * Implementation of iterator current
	 * 
	 * @return mixed 
	 */
	public function current ()
	{
		return \current ($this -> storage);
	}
	
	/**
	 * Implementation of iterator key
	 * 
	 * @return mixed
	 */
	public function key ()
	{
		return \key ($this -> storage);
	}
	
	/**
	 * implementation of iterator next
	 * 
	 * @return mixed 
	 */
	public function next ()
	{
		return \next ($this -> storage);
	}
	
	/**
	 * Implementation of iterator valid
	 * 
	 * @return bool
	 */
	public function valid ()
	{
		$key	= \key ($this -> storage);
		return ($key !== NULL) && ($key !== false);
	}
	
	// -[ Crud implementation starts here ]-------------------------------------
	
	/**
	 * Add a new item to the session
	 * 
	 * @param mixed $data
	 * @param scalar $key
	 * @return \gordian\reefknot\storage\session\Session
	 * @throws \InvalidArgumentException 
	 */
	public function createItem ($data, $key)
	{
		if (is_scalar ($key))
		{
			if (!array_key_exists ($key, $this -> storage))
			{
				$this -> storage [$key]	= $data;
			}
		}
		else
		{
			throw new \InvalidArgumentException (__METHOD__ . ': Key is not valid');
		}
		return $this;
	}
	
	/**
	 * Delete the specified key
	 * 
	 * @param scalar $key 
	 * @return \gordian\reefknot\storage\session\Session 
	 */
	public function deleteItem ($key)
	{
		unset ($this -> storage [$key]);
		return $this;
	}
	
	/**
	 * Retrieve the data stored in the specified key
	 * 
	 * @param scalar $key 
	 * @return mixed
	 */
	public function readItem ($key)
	{
		return (array_key_exists ($key, $this -> storage)? 
			$this -> storage [$key]: 
			NULL);
	}
	
	/**
	 * Update a previously stored data item to a new value
	 * 
	 * @param mixed $data 
	 * @param scalar $key
	 * @return \gordian\reefknot\storage\session\Session
	 * @throws \InvalidArgumentException 
	 */
	public function updateItem ($data, $key)
	{
		if (is_scalar ($key))
		{
			if (array_key_exists ($key, $this -> storage))
			{
				$this -> storage [$key]	= $data;
			}
		}
		else
		{
			throw new \InvalidArgumentException (__METHOD__ . ': Key is not valid');
		}
		return $this;
	}
	
	// -[ Session implementation starts here ]----------------------------------
	
	/**
	 * Clear the session of all stored data
	 * 
	 * @return \gordian\reefknot\storage\session\Session 
	 */
	public function reset ()
	{
		$this -> storage = array ();
		return $this;
	}
	
	/**
	 * Return whether there is data stored in this session
	 * 
	 * @return bool 
	 */
	public function hasData ()
	{
		return (!empty ($this -> storage));
	}
	
	/**
	 * Initialize the back-end storage for the session
	 * 
	 * This method attempts to start the PHP session and bind the storage 
	 * property to the specified session array.  If the session could not be 
	 * started then an exception is thrown.  If the session is already started
	 * then the method proceeds straight to binding the storage property to the
	 * session. 
	 * 
	 * @return \gordian\reefknot\storage\session\Session
	 * @throws \RuntimeException Will be thrown if the session failed to start
	 */
	protected function initStorage ()
	{
		// Check that storage hasn't already been bound to the session
		if ($this -> storage === NULL)
		{
			// Attempt to start the session if it hasn't already been started
			if (($this -> binding -> sessionId () !== '')
			|| ((!$this -> binding -> headersSent ())
			&& ($this -> binding -> startSession ())))
			{
				// Bind the storage to the session
				$this -> storage	=& $this -> binding -> getNamespace ($this -> namespace);
				// Make sure the session is in a usable state
				if (!$this -> hasData ())
				{
					$this -> reset ();
				}
			}
			else
			{
				// We couldn't start the session
				throw new \RuntimeException (__METHOD__ . ': Unable to initiate session storage at this time');
			}
		}
		return $this;
	}
	
	/**
	 * Class constructor
	 *
	 * @param iface\Binding $binding
	 * @param scalar $namespace
	 * @throws \InvalidArgumentException 
	 */
	public function __construct (iface\Binding $binding, $namespace)
	{
		if ((is_scalar ($namespace))
		&& (!empty ($namespace)))
		{
			$this -> binding	= $binding;
			$this -> namespace	= $namespace;
			$this -> initStorage ();
		}
		else
		{
			throw new \InvalidArgumentException (__METHOD__ . ': Session must have a valid name');
		}
	}
}
