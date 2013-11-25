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
 * @author Gordon McVey
 * @category Reefknot
 * @package HTTP
 */
class Response implements iface\Response
{
	private	$statusMessages	= array (
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
		
	/**
	 * HTTP response status
	 *
	 * The HTTP response status code (200 for OK, 404 for not found, etc)
	 *
	 * @var int
	 */
	private	$status			= self::ERR_S_INTERNAL;
	
	/**
	 * HTTP headers to be sent with this response
	 *
	 * The headers are encoded as an associative array, with the key defining
	 * the header key (the text to the left of the : character) and the value
	 * defining the header value (the text to the right of the : character)
	 *
	 * @var array
	 */
	private	$headers		= array ();

	/**
	 * Body of the response to be sent
	 *
	 * @var mixed
	 */
	private $body			= NULL;
	
	/**
	 * Determine if the given code is a valid HTTP status code
	 * 
	 * @param type $code
	 * @return type 
	 */
	public function validCode ($code)
	{
		return array_key_exists ((int) $code, $this -> statusMessages);
	}
	
	/**
	 * Set the response status code
	 * 
	 * @param int $status
	 * @return Response
	 * @throws \InvalidArgumentException
	 */
	public function setStatus ($status)
	{
		$status	= intval ($status);
		
		if ($this -> validCode ($status))
		{
			$this -> status	= $status;
		}
		else
		{
			// Status code not recognised
			throw new \InvalidArgumentException (__METHOD__ . ': Invalid HTTP response code - ' . (string) $status);
		}
		
		return $this;
	}
	
	/**
	 * Get the current HTTP response code
	 * 
	 * @return int 
	 */
	public function getStatus ()
	{
		return $this -> status;
	}
	
	/**
	 * Get the textual message for the current HTTP status code
	 * 
	 * @return string
	 */
	public function getStatusMessage ()
	{
		return $this -> statusMessages [$this -> getStatus ()];
	}
	
	/**
	 * Get the full HTTP status header
	 * 
	 * @return string 
	 */
	public function getStatusHeader ()
	{
		return	self::HTTP_VER_11 . ' ' 
				. $this -> getStatus () . ' ' 
				. $this -> getStatusMessage ();
	}
	
	/**
	 * Set a HTTP header to send with this response
	 * 
	 * @param string $key
	 * @param string $value
	 * @return Response 
	 */
	public function setHeader ($key, $value)
	{
		$this -> headers [$key]	= $value;
		return $this;
	}
	
	/**
	 *
	 * @param string $body
	 * @return Response
	 * @throws \InvalidArgumentException 
	 */
	public function setBody ($body)
	{
		if (is_string ($body))
		{
			$this -> setHeader ('Content-Length', strlen ($body));
			$this -> body	= $body;
		}
		else
		{
			throw new \InvalidArgumentException ();
		}
		
		return $this;
	}
	
	/**
	 *
	 * @return string 
	 */
	public function getBody ()
	{
		return $this -> body;
	}
	
	/**
	 * Send the HTTP headers to the client
	 * 
	 * @return Response 
	 */
	private function sendHeaders ()
	{
		header ($this -> getStatusHeader ());
		
		foreach ($this -> headers as $key -> $val)
		{
			header ($key . ': ' . $val, true);
		}
		
		return $this;
	}
	
	/**
	 *
	 * @return Response 
	 */
	private function sendBody ()
	{
		echo $this -> body;
		return $this;
	}
	
	/**
	 * 
	 * @return \gordian\reefknot\http\Response
	 * @throws \Exception
	 */
	private function send ()
	{
		if (!\headers_sent ())
		{
			$this -> sendHeaders ();
			$this -> sendBody ();
		}
		else
		{
			// Headers already sent
			throw new \Exception ();
		}
		return $this;
	}
}
