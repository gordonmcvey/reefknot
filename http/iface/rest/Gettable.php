<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\http\iface\rest;

use
	gordian\reefknot\http\iface\Request,
	gordian\reefknot\http\iface\Response;

/**
 * Gettable REST interface
 * 
 * A class implementing this interface is expected to be able to respond to a 
 * HTTP GET or HEAD request.  
 * 
 * An object that can respond to GET must also be able to respond to HEAD.  For 
 * this reason, there is no Headable interface.  
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package HTTP
 * @subpackage REST
 * @subpackage Interfaces
 */
interface Gettable extends Restful
{
	/**
	 * 
	 * @param Request $request Request object that triggered the action
	 * @return mixed Result of the operation to be formatted by a Representation
	 */
	public function httpGet (Request $request);
}
