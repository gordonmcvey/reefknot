<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\http\request;

use
	gordian\reefknot\http\iface;

/**
 * Object for accessing the request body
 * 
 * This object implements access to the body of a HTTP request.  Normally PHP
 * will process this into the $_POST array on POST requests, but for other HTTP
 * verbs such as PUT we need to handle it ourselves.  You can use an instance
 * of this class to access the raw body data, save it to a file, or parse it as
 * parameters.  
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package HTTP
 * @subpackage Request
 * @todo Request body parsing based on request content-* headers
 */
class RequestBody implements iface\request\RequestBody
{
	const
		
		/**
		 * File descriptor for the request body's stream
		 */
		REQ_PATH	= 'php://input',
		
		/**
		 * How much data to read in bytes before writing it to the target file.
		 * Default is 10 K
		 */
		BUFFER_SIZE	= 10240;
		
	protected
		
		/**
		 * The request object the body is bound to
		 * 
		 * @var iface\Request
		 */
		$request		= NULL,
		
		/**
		 * The raw entity body data
		 * 
		 * @var mixed 
		 */
		$data			= NULL,
		
		/**
		 * The entity body data parsed as query data
		 * 
		 * @var array 
		 */
		$params			= NULL, 
		
		/**
		 * 
		 */
		$requestHandle	= false;
	
	/**
	 * Obtain a handle to the request body
	 * 
	 * @return resource a file pointer resource on success, or <b>FALSE</b> on error.
	 */
	protected function getHandle ()
	{
		if (empty ($this -> requestHandle))
		{
			$this -> requestHandle	= fopen (static::REQ_PATH, 'rb');
		}
		return $this -> requestHandle;
	}
	
	/**
	 * Close the request body handle
	 * 
	 * @param resource $handle
	 * @return boolean True on success
	 */
	protected function closeHandle ()
	{
		if ((!empty ($this -> requestHandle))
		&& (fclose ($this -> requestHandle)))
		{
			$this -> requestHandle	= false;
		}
		return (empty ($this -> requestHandle));
	}
	
	/**
	 * Test whether or not the request data has been parsed
	 * 
	 * @return boolean
	 */
	public function bodyParsed ()
	{
		return !is_null ($this -> data);
	}
	
	/** 
	 * Get the raw request body data
	 * 
	 * This method reads and returns the contents of php://input.  For HTTP 
	 * requests, this will contain request body. 
	 * 
	 * @return mixed The raw request body data
	 */
	public function getData ()
	{
		if (!$this -> bodyParsed ())
		{
			$this -> data	= false;
			if (false !== ($handle = $this -> getHandle ()))
			{
				while (false !== ($buffer = fread ($handle, static::BUFFER_SIZE)))
				{
					$this -> data	.= $buffer;
				}
				$this -> closeHandle ();
			}
		}
		
		return $this -> data;
	}
	
	/**
	 * Write the raw request body data to disc
	 * 
	 * This method is intended for use when doing HTTP PUT operations, or other 
	 * operations that could result in a large request body, as loading the data 
	 * into the object and parsing it could potentially be very expensive in 
	 * terms of both memory and processing load. 
	 * 
	 * As the use case that would normally be expected with large request 
	 * bodies is uploading a file with HTTP PUT, the best thing to do in such 
	 * circumstances is to write the request body data to a file.  This method
	 * reads from the input stream in relatively small chunks and writes them
	 * to the specified target path. 
	 * 
	 * For most other scenarios the normal getters would normally be used.  
	 * 
	 * @link http://www.php.net/manual/en/function.fopen.php See the fopen documentation for details of valid $mode flags
	 * @param string $filename The filename to save the data under
	 * @param string $mode The mode flag to use on the target.  Identical to PHP fopen() mode flag.  Must be a node that allows writing to the file
	 * @return int Number of bytes written to disc 
	 */
	public function saveData ($filename, $mode = 'wb')
	{
		$written	= 0;
		
		// If we've not already read the request body then copy the source to the destination
		if (!$this -> bodyParsed ())
		{
			$this -> data	= false;
			
			// Open input stream and target file
			if ((false !== ($source = $this -> getHandle ()))
			&& (false !== ($target = fopen ($filename, $mode)))
			&& (flock ($target, LOCK_EX)))
			{
				// Copy input data to target file in 1K chunks
				while (false !== ($buffer = fread ($source, static::BUFFER_SIZE)))
				{
					$written	+= fwrite ($target, $buffer);
				}
				
				$this -> closeHandle ();
			}
			
			// Clean up target file
			if ((isset ($target)) && ($target))
			{
				flock ($target, LOCK_UN);
				fclose ($target);				
			}
		}
		else
		{
			// If the request body has already been parsed then write the contents of the parsed data to the filesystem
			$written	= file_put_contents ($filename, $this -> getData (), LOCK_EX);
		}
		
		return $written;
	}
	
	/**
	 * Get the request body data as an array parsed as a query string
	 * 
	 * This method attempts to parse the request body as if it was a query 
	 * string.  If it succeeds, it returns an array of request body data. 
	 * 
	 * @return array 
	 */
	public function getAsParams ()
	{
		if (!$this -> bodyParsed ())
		{
			parse_str ($this -> getData (), $this -> params);
		}
		
		return $this -> params;
	}
	
	/**
	 * Get the named parameter from the request body data
	 * 
	 * @param string $key
	 * @return mixed 
	 */
	public function getParam ($key)
	{
		$val	= NULL;
			
		if (($data = $this -> getAsParams ())
		&& (array_key_exists ($key, $data)))
		{
			$val	= $data [$key];
		}
		
		return $val;
	}
	
	/**
	 * Class constructor
	 * 
	 * @param \gordian\reefknot\http\iface\Request $request
	 */
	public function __construct (iface\Request $request)
	{
		$this -> request	= $request;
	}
}
