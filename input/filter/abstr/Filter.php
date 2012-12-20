<?php

namespace gordian\reefknot\input\filter\abstr;

use gordian\reefknot\input\filter\iface;

/**
 * Description of Filter
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Input
 * @subpackage Filtering
 */
abstract class Filter implements iface\Filter
{
	protected 
		$data	= NULL,
		$config	= array ();
	
	public function setData ($data)
	{
		$this -> data	= $data;
		return $this;
	}
	
	public function setConfig (array $config)
	{
		$this -> config	= $config;
		return $this;
	}
	
	public function getConfig ()
	{
		return $this -> config;
	}
	
	public function __construct (array $config	= NULL)
	{
		if (!empty ($config))
		{
			$this -> setConfig ($config);
		}
	}
}
