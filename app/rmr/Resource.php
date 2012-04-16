<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\app\rmr;

use
	gordian\reefknot\http\iface\Request,
	gordian\reefknot\http\iface\Response;

/**
 * Description of Resource
 *
 * @author gordonmcvey
 */

class Resource implements iface\Resource
{
	protected
		
		/**
		 * @var Request 
		 */
		$request	= NULL,
		
		/**
		 * @var Response 
		 */
		$response	= NULL;
	
	/**
	 *
	 * @return Response 
	 */
	public function getRequest ()
	{
		return ($this -> request);
	}
	
	/**
	 *
	 * @param Request $request
	 * @return Resource 
	 */
	public function setRequest (Request $request)
	{
		$this -> request	= $request;
		return ($this);
	}
	
	/**
	 *
	 * @return Response 
	 */
	public function getResponse ()
	{
		return ($this -> response);
	}
	
	/**
	 *
	 * @param Response $response
	 * @return Response 
	 */
	public function setResponse (Response $response)
	{
		$this -> response	= $response;
		return ($this);
	}
	
	public function __construct (Request $request, Response $response)
	{
		$this	-> setRequest($request)
				-> setResponse($response);
	}
}
