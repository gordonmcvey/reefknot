<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate;

/**
 * DataSet validation unit
 * 
 * A dataset is a collection of one or more fields.  This collection can be used
 * to validate a set of data (an array) against the defined rules to see if it
 * is valid.  A dataset can also be a field, allowing for nested validation 
 * structures for testing nested arrays to be built.  
 *
 * @author Gordon McVey
 */
class Group extends abstr\BasicValidatable implements iface\BasicValidatable
{
	public function isValid ()
	{
		return (false);
	}
}
