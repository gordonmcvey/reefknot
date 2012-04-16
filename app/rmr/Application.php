<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\app\rmr;

/**
 * RMR application
 *
 * @author Gordon McVey
 */
class Application
{
	/**
	 * Perform the operations needed to fufill the current invokation 
	 */
	public function main ()
	{
		// Process the request
		// Pass the request to the resolver to determine the object to be invoked
		// Invoke the target object and pass it the request
		// Collect the object response
		// Pass the result of the object invokation to the responder
		// Send the response from the responder to the output
	}
}
