<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\filter;

/**
 * Description of Keys
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Input
 * @subpackage Filtering
 */
class Keys extends abstr\Filter
{
	public function setConfig (array $config)
	{
		if ((isset ($config ['keys']))
		&& (is_array ($config ['keys'])))
		{
			return parent::setConfig ($config);
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
		
		return $this -> data;
	}
	
	public function __construct (array $config)
	{
		parent::__construct ($config);
	}
}

