<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\util;

/**
 * Class for generating a random password
 *
 * @author gordonmcvey
 */
class Password
{
	const 
		CHARLIST	= '1234567890qwertyuiopasdfghjklzxcvbnm_-QWERTYUIOPASDFGHJKLZXCVBNM';
	
	protected 
		$min		= 12,
		$max		= 16,
		$password	= '';
	
	/**
	 * Get the generated password
	 * 
	 * This method returns the password generated for this instance of the 
	 * password class (or generates the password if it hasn't been set yet). 
	 * 
	 * @return string
	 */
	public function getPassword ()
	{
		if ($this -> password == '')
		{
			$pw				= '';
			$charListEnd	= strlen (static::CHARLIST) - 1;
			for ($loops = mt_rand ($this -> min, $this -> max); $loops > 0; $loops--)
			{
				$pw	.= substr (static::CHARLIST, mt_rand (0, $charListEnd), 1);
			}
			$this -> password	= $pw;
		}
		return ($this -> password);
	}
	
	/**
	 * Class constructor
	 * 
	 * When this class generates a password, the generated password will be of 
	 * a random length, between the bounds specified by the $min and $max 
	 * properties of the instance. So if the min is 12 and the max is 16, the 
	 * generated password will be of a random length between 12 and 16 
	 * characters long
	 * 
	 * @param int $min The lower bounds of the password length
	 * @param int $max The upper bounds of the password length
	 */
	public function __construct ($min = 0, $max = 0)
	{
		if (($min = intval ($min)) > 0)
		{
			$this -> min	= $min;
		}
		
		if (($max = intval ($max)) > 0)
		{
			$this -> max	= $max;
		}
		
		if ($this -> max < $this -> min)
		{
			throw new \InvalidArgumentException ('Maximum password length cannot be less than minimum password length');
		}
	}
}
