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
 * Optionable REST interface
 * 
 * Classes that implement this interace are expected to be able to respond to
 * a HTTP OPTIONS request. 
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package HTTP
 * @subpackage REST
 * @subpackage Interfaces
 */
interface Optionsable extends Restful
{
	/**
	 * 
	 * @param Request $request Request object that triggered the action
	 * @return mixed Result of the operation to be formatted by a Representation
	 */
	public function httpOptions (Request $request);
}
