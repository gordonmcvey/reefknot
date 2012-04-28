<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\app\rmr;

use 
	gordian\reefknot\http\iface,
	gordian\reefknot\http\iface\rest;

/**
 * RMR application
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package Application
 * @subpackage RMR
 */
class Application implements iface\Application
{
	protected
		
		/**
		 * @var iface\Request
		 */
		$request	= NULL,
		
		/**
		 * @var iface\Response 
		 */
		$response	= NULL,
		
		/**
		 * @var rest\Restful 
		 */
		$target		= NULL;
	
	/**
	 * Tasks to execute before beginning the request-response sequence 
	 */
	protected function preDispatch ()
	{
		
	}
	
	/**
	 * Tasks to execute after the request-response sequence has completed 
	 */
	protected function postDispatch ()
	{
		
	}
	
	/**
	 * Perform the operations needed to fufill the current invokation 
	 */
	public function Run ()
	{
		// Do any pre-dispatch tasks
		$this -> preDispatch ();
		// Process the request
		// Pass the request to the resolver to determine the object to be invoked
		// Invoke the target object and pass it the request
		// Collect the object response
		// Pass the result of the object invokation to the responder
		// Send the response from the responder to the output
		// Do any post-dispatch tasks
		$this -> postDispatch ();
	}
	
	public function __construct (iface\Request $request, iface\Response $response)
	{
		$this -> request	= $request;
		$this -> response	= $response;
	}
}
