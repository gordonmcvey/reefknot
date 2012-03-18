<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\prop;

use
	gordian\reefknot\input\validate\abstr, 
	gordian\reefknot\input\validate\iface;

/**
 * Description of Max
 *
 * @author gordonmcvey
 */
class Max extends abstr\prop\Ranged implements iface\prop\Ranged
{
	/**
	 *
	 * @return bool
	 * @throws \InvalidArgumentException 
	 */
	public function isValid ()
	{
		$valid	= false;
		$limit	= NULL;
		$data	= $this -> getData ();
		
		switch (gettype ($data))
		{
			case 'NULL'		:
				$valid	= true;
			break;
			case 'integer'	:
			case 'double'	:
				$cfg	= $this -> getConfig ();
				if (($limit	= $this -> getLimit ($cfg ['limit'])) !== NULL)
				{
					$valid	= $data <= $limit;
				}
			break;
			case 'string'	:
				$cfg	= $this -> getConfig ();
				if (($limit	= $this -> getLimit ($cfg ['limit'])) !== NULL)
				{
					$valid	= strlen ($data) <= $limit;
				}
			break;
			case 'array'	:
				$cfg	= $this -> getConfig ();
				if (($limit	= $this -> getLimit ($cfg ['limit'])) !== NULL)
				{
					$valid	= count ($data) <= $limit;
				}
			break;
			default			:
				throw new \InvalidArgumentException (__CLASS__ . ': This property cannot be applied to data of type ' . gettype ($data));
			break;
		}
		
		return ($valid);
	}
}
