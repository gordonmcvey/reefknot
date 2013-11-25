<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\type;

use 
	gordian\reefknot\input\validate\abstr, 
	gordian\reefknot\input\validate\iface;

/**
 * Type for validating Boolean data
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package gordian\reefknot\input\validate\type
 */
class IsBool extends IsScalar implements iface\Type
{
	/**
	 * Check that the provided data is a Boolean
	 * 
	 * @return bool True if data is Boolean 
	 */
	public function isValid ()
	{
		$data	= $this -> getData ();
		return ((is_null ($data))
			|| (is_bool ($data)));
	}
}
