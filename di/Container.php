<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\di;

/**
 * Dependency Injection service container
 * 
 * The Container is intended for easily managing complex dependency trees (such
 * as the ones that you tend to get with complicated Validate data and rule 
 * sets).  It is loosely based on the DI container described in the linked 
 * slide show
 * 
 * You can extend this class with a library of standard functions specific to
 * your object graph (so you don't have to keep passing the same closure around
 * all over the place).  
 * 
 * @link http://www.slideshare.net/fabpot/dependency-injection-with-php-53 Dependency Injection with PHP 5.3
 * @author Gordon McVey
 * @category Reefknot
 * @package DependencyInjection
 */
class Container implements iface\Container
{
	private
		$store	= array ();
	
	/**
	 * Add a new parameter to the container
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @return Container 
	 */
	public function __set ($key, $value)
	{
		$this -> store [$key]	= $value;
	}
	
	/**
	 * Retrieve an item from the container
	 * 
	 * @param string $key
	 * @return mixed
	 * @throws \InvalidArgumentException if you attempt to access a non-existant key
	 */
	public function __get ($key)
	{
		$param	= NULL;
		
		if (isset ($this -> store [$key]))
		{
			$param	= is_callable ($this -> store [$key])?
				$this -> store [$key] ($this):
				$this -> store [$key];
		}
		else
		{
			throw new \InvalidArgumentException ('Parameter ' . $key . 'not defined');
		}
		
		return ($param);
	}
	
	/**
	 * Retrieve the same instance of an object from the container.
	 * 
	 * This method provides a singleton-like functionality.  It caches a named
	 * instance of an object and returns the same instance every time it is 
	 * called, instead of creating a new instance 
	 * 
	 * @param \Closure $callable 
	 * @return Object
	 */
	public function single (\Closure $callable)
	{
		return (function ($c) use ($callable)
		{
			static $object	= NULL;
			
			if (is_null ($object))
			{
				$object	= $callable ($c);
			}
			
			return ($object);
		});
	}
}
