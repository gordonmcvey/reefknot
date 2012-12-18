<?php

/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\qpp\web;

use
	\gordian\reefknot\http, 
	\gordian\reefknot\http\iface\Request, 
	\gordian\reefknot\http\iface\Response;

/**
 * Reefknot Front Controller
 * 
 * @author Gordon McVey
 */
class FrontController
{
	private
		
		/**
		 * @var \gordian\reefknot\http\iface\Request
		 */
		$request	= NULL,
		
		/**
		 * @var \gordian\reefknot\http\iface\Response
		 */
		$response	= NULL;
	
	/**
	 * 
	 * @return \gordian\reefknot\http\iface\Request
	 */
	public function getRequest ()
	{
		return $this -> request;
	}
	
	/**
	 * 
	 * @return \gordian\reefknot\http\iface\Response
	 */
	public function getResponse ()
	{
		return $this -> response;
	}
	
	/**
	 * 
	 * @param \gordian\reefknot\http\iface\Request $request
	 * @return \gordian\reefknot\qpplication\web\FrontController
	 */
	public function setRequest (Request $request)
	{
		$this -> request	= $request;
		return $this;
	}
	
	/**
	 * 
	 * @param \gordian\reefknot\http\iface\Response $response
	 * @return \gordian\reefknot\qpplication\web\FrontController
	 */
	public function setResponse (Response $response)
	{
		$this -> response	= $response;
		return $this;
	}
	
	/**
	 * 
	 * @param \gordian\reefknot\http\iface\Request $request
	 */
	public function __construct (Request $request, Response $response)
	{
		$this -> setRequest ($request);
	}
}
