<?php

namespace gordian\reefknot\input\filter;

/**
 * Description of Keys
 *
 * @author gordonmcvey
 */
class Keys extends abstr\Filter
{
	public function setConfig (array $config)
	{
		if ((isset ($config ['keys']))
		&& (is_array ($config ['keys'])))
		{
			return (parent::setConfig ($config));
		}
		else
		{
			throw new \InvalidArgumentException;
		}
	}
	
	public function filter ()
	{
		if (is_array ($this -> data))
		{
			$cfg	= $this -> getConfig ();
			$this -> data	= array_intersect_key ($this -> data, array_flip ($cfg ['keys']));
		}
		
		return ($this -> data);
	}
	
	public function __construct (array $config)
	{
		parent::__construct ($config);
	}
}

