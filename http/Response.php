<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\http;

/**
 * Description of Response
 *
 * @author gordonmcvey
 */
class Response implements iface\Response
{
	private 
		$statusMessages	= array (
			self::INF_CONTINUE			=> 'Continue',
			self::INF_SWITCHING			=> 'Switching Protocols',
			self::SUC_OK				=> 'OK',
			self::SUC_CREATED			=> 'Created',
			self::SUC_ACCEPTED			=> 'Accepted',
			self::SUC_NON_AUTH			=> 'Non-Authoritative Information',
			self::SUC_NO_CONTENT		=> 'No Content',
			self::SUC_RESET_CONTENT		=> 'Reset Content',
			self::SUC_PARTIAL			=> 'Partial Content',
			self::RDR_MULTIPLE			=> 'Multiple Choices',
			self::RDR_PERMANENT			=> 'Moved Permanently',
			self::RDR_FOUND				=> 'Found',
			self::RDR_SEEOTHER			=> 'See Other',
			self::RDR_NOTMODDED			=> 'Not Modified',
			self::RDR_PROXY				=> 'Use Proxy',
			self::RDR_RESERVED			=> 'unused',
			self::RDR_TEMPORARY			=> 'Temporary Redirect',
			self::ERR_C_BADREQ			=> 'Bad Request',
			self::ERR_C_UNAUTHED		=> 'Unauthorized',
			self::ERR_C_PAYREQ			=> 'Payment Required',
			self::ERR_C_FORBIDDEN		=> 'Forbidden',
			self::ERR_C_NOTFOUND		=> 'Not Found',
			self::ERR_C_METHOD			=> 'Method Not Allowed',
			self::ERR_C_UNACCEPTABLE	=> 'Not Acceptable',
			self::ERR_C_AUTH_PROXY		=> 'Proxy Authentication Required',
			self::ERR_C_TIMEOUT			=> 'Request Timeout',
			self::ERR_C_CONFLICT		=> 'Conflict',
			self::ERR_C_GONE			=> 'Gone',
			self::ERR_C_NOLENGTH		=> 'Length Required',
			self::ERR_C_PRECONDITION	=> 'Precondition Failed',
			self::ERR_C_TOOLARGE		=> 'Request Entity Too Large',
			self::ERR_C_URILONG			=> 'Request-URI Too Long',
			self::ERR_C_MEDIATYPE		=> 'Unsupported Media Type',
			self::ERR_C_RANGE			=> 'Requested Range Not Satisfiable',
			self::ERR_C_EXPECTATION		=> 'Expectation Failed',
			self::ERR_S_INTERNAL		=> 'Internal Server Error',
			self::ERR_S_UNIMPLEMENTED	=> 'Not Implemented',
			self::ERR_S_GATEWAY			=> 'Bad Gateway',
			self::ERR_S_UNAVAILABLE		=> 'Service Unavailable',
			self::ERR_S_TIMEOUT			=> 'Gateway Timeout',
			self::ERR_S_VERSION			=> 'Version Not Supported'
		);
	
	protected
		
		/**
		 * HTTP headers to be sent with this response
		 * 
		 * @var array 
		 */
		$head	= array (),
		
		/**
		 * Body of the response to be sent
		 * 
		 * @var mixed 
		 */
		$body	= NULL;
	
	/**
	 * Determine if the given code is a valid HTTP status code
	 * 
	 * @param type $code
	 * @return type 
	 */
	public function validCode ($code)
	{
		return (array_key_exists (intval ($code), $this -> statusMessages));
	}
	
	/**
	 * Get the textual message for the given HTTP status code
	 * 
	 * @param int $code 
	 * @return string
	 * @throws \InvalidArgumentException
	 */
	public function getStatusMessage ($code)
	{
		$code	= intval ($code);
		if (!$this -> validCode ($code))
		{
			throw new \InvalidArgumentException;
		}
		return ($this -> statusMessages [$code]);
	}
	
	public function getResponseString ($code)
	{
		return (	self::HTTP_VER_11 
					. ' ' 
					. $code 
					. ' ' 
					. $this -> getStatusMessage ($code));
	}
}
