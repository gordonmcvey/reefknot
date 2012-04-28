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
 * Traceable REST interface
 * 
 * Classes implementing this interface are expected to be able to respond to a 
 * HTTP TRACE request.  
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package HTTP
 * @subpackage REST
 * @subpackage Interfaces
 */
interface Traceable extends Restful
{
	/**
	 * 
	 * @param Request $request Request object that triggered the action
	 * @return mixed Result of the operation to be formatted by a Representation
	 */
	public function httpTrace (Request $request);
}
