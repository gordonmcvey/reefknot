<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\app\rmr\iface;

use
	gordian\reefknot\http\iface;

/**
 * Resolver interface
 * 
 * Resolvers are objects that map a HTTP request onto a Resource (a Resource 
 * being a business object that can be operated on directly by the RMR 
 * architecture).  As how a HTTP request maps onto a Resource is a requirement
 * that is very much application specific, you will probably have to provide 
 * your own implementation.  
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Application
 * @subpackage RMR
 * @subpackage Interfaces
 */
interface Resolver
{
	/**
	 * Find the business object that the provided request is targeted at. 
	 * 
	 * @param iface\Request $request
	 * @return iface\rest\Restful
	 */
	public function getTarget (iface\Request $request);
}
