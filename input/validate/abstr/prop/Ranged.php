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
 *
 * @author gordonmcvey
 */
abstract class Ranged extends Prop implements iface\prop\Ranged
{
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
				if (!is_numeric ($val = $limit -> getData ()))
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
			throw new \InvalidArgumentException;
		}
	}
}
