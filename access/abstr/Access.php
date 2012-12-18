<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\access\abstr;

use
	gordian\reefknot\access\iface;

/**
 * Base implementation of access control classes
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Access
 */
abstract class Access implements iface\Access
{
	private
		
		/**
		 * The object that is requesting access to the resource
		 * 
		 * @var iface\Consumer
		 */
		$consumer	= NULL,
		
		/**
		 * The object that the consumer is requesting access to
		 * 
		 * @var iface\Resource
		 */
		$resource	= NULL;
}
