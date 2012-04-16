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
 * Deleteable REST interface
 * 
 * Classes that implement this interface should be able to respond to a HTTP
 * DELETE request. 
 * 
 * @author Gordon McVey
 */
interface Deleteable extends Restable
{
	public function httpDelete (Request $request);
}
