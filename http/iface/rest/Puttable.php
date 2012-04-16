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
 * Puttable REST interface
 * 
 * A class implementing this interface is expected to be able to respond to a 
 * HTTP PUT request. 
 * 
 * @author Gordon McVey
 */
interface Puttable extends Restable
{
	public function httpPut (Request $request);
}
