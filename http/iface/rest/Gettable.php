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
 * HTTP GET request.  
 * 
 * @author Gordon McVey
 */
interface Gettable extends Restable
{
	public function httpGet (Request $request);
}
