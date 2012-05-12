<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\l10n\gb\input\validate\prop;

use
	gordian\reefknot\input\validate\abstr, 
	gordian\reefknot\input\validate\iface;

/**
 * Test strings for validity as UK phone numbers
 * 
 * Note: This validator only provides a sanity check on the number and make sure
 * that the format is valid according to the rules of UK phone numbers.  It is
 * not intended to do a comprehensive validation.  It does not, for example, 
 * check that the area code is valid.  To do this would require comparing the
 * number against a list of valid area codes.  As such a list is subject to 
 * change, it would have to be provided from an external data source and 
 * introduce a coupling between this component and any component that provides
 * the list.  
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Validate
 * @subpackage Prop
 */
class PhoneUk extends abstr\Prop implements iface\Prop
{
	const 
		
		/**
		 * The UK phone number prefix format.  
		 * 
		 * A prifix is either the UK international dialing code (+44) or the trunk code (0) 
		 */
		PREFIX			= '(?:0|\+44)',
		
		/**
		 * Regular expression description of a standard UK telephone number
		 * 
		 * UK phone numbers break down into the following parts:
		 * * A prefix (see PREFIX)
		 * * A digit with the values (1, 2, 3, 5, 7, 8, 9)
		 * * A sequence of 8 or 9 digits 
		 */
		PATTERN			= '[1235789]\d{8,9}';
	
	protected 
		
		/**
		 * List of regular expression patterns for the various classes of phone number
		 * 
		 * @var array 
		 */
		$numberTypes	= array (
			'landline'	=> '[12]',
			'national'	=> '3',
			'corp'		=> '5',
			'mobile'	=> '7',
			'special'	=> '8',
			'premium'	=> '9'
		);
		
	/**
	 * Configure the validator
	 * 
	 * The configuration for this validator consists of a series of flags that
	 * modify what can be considered valid for this instance of the validator. 
	 * 
	 * The following flags are supported:
	 * 
	 * * landline: Geographically-bound land lines (01, 02)
	 * * national: Non-geographic land lines (03)
	 * * corp: Corporate, VOIP and 0500 freephone numbers (05)
	 * * mobile: Cellular devices (07)
	 * * special: Frephone numbers and local/national rate numbers (08)
	 * * premium: Premium-rate numbers (09)
	 * 
	 * @param array $config
	 * @return PhoneUk 
	 * @throws \InvalidArgumentException 
	 * @link http://en.wikipedia.org/wiki/Telephone_numbers_in_the_United_Kingdom
	 */
	public function setConfig (array $config = array ())
	{
		// Normalize array
		$config ['landline']	= isset ($config ['landline'])? 
			(bool) $config ['landline']: 
			false;
		$config ['national']	= isset ($config ['national'])? 
			(bool) $config ['national']: 
			false;
		$config ['corp']		= isset ($config ['corp'])? 
			(bool) $config ['corp']: 
			false;
		$config ['mobile']		= isset ($config ['mobile'])? 
			(bool) $config ['mobile']: 
			false;
		$config ['special']		= isset ($config ['special'])? 
			(bool) $config ['special']: 
			false;
		$config ['premium']		= isset ($config ['premium'])? 
			(bool) $config ['premium']: 
			false;
		
		// Check that at least one of the flags is set to true, otherwise nothing would validate!
		if (!in_array (true, $config, true))
		{
			throw new \InvalidArgumentException (__CLASS__ . ': The given configuration is not valid ' . var_export ($config, true));
		}
		
		return parent::setConfig ($config);
	}
	
	/**
	 * Test that a number matches against the flags set in the config 
	 * 
	 * Flags are applied on a logical-or fashion.  If landline and mobile are 
	 * set, then this method will return true if the given number if valid as
	 * as landline number, or if it is valid as a mobile number. 
	 * 
	 * @param string $number 
	 * @return bool True if the number conforms to the config
	 */
	protected function numberMatchesFlags ($number)
	{
		$valid	= false;
		$cfg	= array_keys (array_filter ($this -> getConfig ()));
		
		// Test number against the set flags
		foreach ($cfg as $flag)
		{
			$valid	= isset ($this -> numberTypes [$flag]) 
					&& (preg_match ('/^' . static::PREFIX . $this -> numberTypes [$flag] . '/', $number) > 0);
			
			if ($valid)
			{
				break;
			}
		}
		
		return $valid;
	}
	
	/**
	 * Test that the given data is valid as a UK phone number
	 * 
	 * @return bool True if valid
	 * @throws \InvalidArgumentException 
	 */
	public function isValid ()
	{
		$valid	= false;
		$data	= $this -> getData ();
		
		switch (gettype ($data))
		{
			case 'NULL'		:
				$valid	= true;
			break;
			case 'string'	:
				$valid	= (preg_match ('/^' . static::PREFIX . static::PATTERN . '\z/', $data) > 0)
						&& ($this -> numberMatchesFlags ($data));
			break;
			default			:
				throw new \InvalidArgumentException (__CLASS__ . ': This property cannot be applied to data of type ' . gettype ($data));
			break;
		}
		
		return $valid;
	}
}
