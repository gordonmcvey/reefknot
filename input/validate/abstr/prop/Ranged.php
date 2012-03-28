<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\abstr\prop;

use
	gordian\reefknot\input\validate\iface,
	gordian\reefknot\input\validate\abstr\Prop;

/**
 * Ranged prop
 * 
 * A ranged prop is a prop that allows the testing of some aspect of the size of
 * a value.  For example, a ranged prop can be used to test the number of 
 * elements in an array, or the length of a string.  The config of a ranged 
 * prop includes a limit attribute that defines the value that the range must 
 * meet.  
 * 
 * @author Gordon McVey
 */
abstract class Ranged extends Prop implements iface\prop\Ranged
{
	/**
	 * Determine if the value specified for limit is valid.  
	 * 
	 * A limit value is valid if it is numeric, or if it is an instance of a 
	 * field.  In the latter case the value stored in the field is used as the
	 * limit.  
	 * 
	 * @param Field $limit
	 * @return type 
	 */
	protected function validLimit ($limit)
	{
		return (($limit instanceof iface\Field)
			|| ((is_numeric ($limit))
			&& ($limit > 0)));
	}
	
	/**
	 * Get the value to validate against
	 * 
	 * @param mixed $limit
	 * @return mixed 
	 */
	protected function getLimit ($limit)
	{
		$val	= NULL;
		
		if ($limit instanceof iface\Field)
		{
			if ($limit -> isValid ())
			{
				if (!$this -> validLimit ($val = $limit -> getData ()))
				{
					$val	= NULL;
				}
			}
		}
		else
		{
			$val	= $limit;
		}
		return ($val);
	}
	
	/**
	 * Configure the rangeed limit
	 * 
	 * All ranged props have a limit configuration item that must be set.  This
	 * method implements the configuration of the limit. 
	 * 
	 * @param array $config
	 * @return Ranged
	 * @throws \InvalidArgumentException 
	 */
	public function setConfig (array $config = array ())
	{
		if ((isset ($config ['limit']))
		&& ($this -> validLimit ($config ['limit'])))
		{
			return (parent::setConfig ($config));
		}
		else
		{
			throw new \InvalidArgumentException (__CLASS__ . ': The given configuration is not valid  -- [ ' . var_export ($config, true) . ' ]');
		}
	}
}
