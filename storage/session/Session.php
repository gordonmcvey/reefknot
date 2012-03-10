<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\storage\session;

use gordian\reefknot\storage;

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
 * @author gordonmcvey
 * @todo implement Iterator interface
 */
class Session implements storage\iface\Crud, iface\Session, \Countable, \Iterator
{
	
	protected
		
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
	
	/**
	 * Implementation of iterator rewind 
	 * 
	 * @return mixed
	 */
	public function rewind ()
	{
		return (\reset ($this -> storage));
	}
	
	/**
	 * Implementation of iterator current
	 * 
	 * @return mixed 
	 */
	public function current ()
	{
		return (\current ($this -> storage));
	}
	
	/**
	 * Implementation of iterator key
	 * 
	 * @return mixed
	 */
	public function key ()
	{
		return (\key ($this -> storage));
	}
	
	/**
	 * implementation of iterator next
	 * 
	 * @return mixed 
	 */
	public function next ()
	{
		return (\next ($this -> storage));
	}
	
	/**
	 * Implementation of iterator valid
	 * 
	 * @return bool
	 */
	public function valid ()
	{
		$key	= \key ($this -> storage);
		return (($key !== NULL) && ($key !== false));
	}
	
	// -[ Countable implementation starts here ]--------------------------------
	
	/**
	 * Implementation of countable count
	 * 
	 * @return type 
	 */
	public function count ()
	{
		return (count ($this -> storage));
	}
	
	// -[ Session implementation starts here ]----------------------------------
	
	/**
	 * Add a new item to the session
	 * 
	 * @param mixed $data 
	 * @param string $key
	 * @return Session
	 * @throws \InvalidArgumentException Thrown if no name is provided
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
			throw new \InvalidArgumentException ('No valid key given');
		}
		return ($this);
	}
	
	/**
	 * Delete the specified key
	 * 
	 * @param string $key 
	 * @return Session
	 */
	public function deleteItem ($key)
	{
		unset ($this -> storage [$key]);
		return ($this);
	}
	
	/**
	 * Retrieve the data stored in the specified key
	 * 
	 * @param type $key 
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
	 * @param string $key
	 */
	public function updateItem ($data, $key)
	{
		if (array_key_exists ($key, $this -> storage))
		{
			$this -> storage [$key]	= $data;
		}
		return ($this);
	}
	
	/**
	 * Clear the session of all stored data
	 * 
	 * @return Session 
	 */
	public function reset ()
	{
		$this -> storage = array ();
		return ($this);
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
	 * This method provides access for this class to the underlying PHP session
	 * mechanism.  
	 * 
	 * This is the only place in the class to directly access the session, so 
	 * if you need to swap the actual session out for a substitute (for a unit
	 * test, for example), then you can override this method to replace the 
	 * session with whatever storage mechanism you have in mind.  Alternatively
	 * you can redeclare the following functionw within the Session namespace 
	 * and this method will use them instead of the ones provided by PHP:
	 * 
	 * * session_id
	 * * session_start
	 * * headers_sent
	 * 
	 * @return bool Whether the newly initialized session contains data or not
	 * @throws \RuntimeException Will be thrown if the session failed to start
	 */
	protected function initStorage ()
	{
		// Check that storage hasn't already been initialized
		if ($this -> storage === NULL)
		{
			// Attempt to start the session if it hasn't already been started
			if ((session_id () === '')
			&& ((headers_sent ()) 
			|| ((!session_start ()))))
			{
				throw new \RuntimeException ('Unable to start session at this time');
			}
			// Alias our instance storage to the named $_SESSION variable
			$this -> storage	=& $_SESSION [$this -> namespace];
			// Make sure the session is in a usable state
			if (!$this -> hasData ())
			{
				$this -> reset ();
			}
		}
		return ($this -> hasData ());
	}
	
	/**
	 * Class constructor
	 * 
	 * @param string $namespace
	 * @throws \InvalidArgumentException Thrown if no session name is provided
	 */
	public function __construct ($namespace)
	{
		if ((is_scalar ($namespace))
		&& (!empty ($namespace)))
		{
			$this -> namespace	= $namespace;
			$this -> initStorage ();
		}
		else
		{
			throw new \InvalidArgumentException ('Session must have a name');
		}
	}
}
