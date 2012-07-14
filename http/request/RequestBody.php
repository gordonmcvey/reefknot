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
 */
class RequestBody implements iface\request\RequestBody
{
	const
		REQ_PATH	= 'php://input',
		BUFFER_SIZE	= 1024;
		
	protected
		
		/**
		 * The raw entity body data
		 * 
		 * @var mixed 
		 */
		$data	= NULL,
		
		/**
		 * The entity body data parsed as query data
		 * 
		 * @var array 
		 */
		$params	= NULL;
	
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
		if ($this -> data === NULL)
		{
			$this -> data	= false;
			if (false !== ($handle = fopen (static::REQ_PATH, 'r')))
			{
				while ($buffer = fread ($handle, static::BUFFER_SIZE))
				{
					$this -> data	.= $buffer;
				}
				fclose ($handle);
			}
		}
		
		return $this -> data;
	}
	
	/**
	 * Write the raw request body data to disc
	 * 
	 * This method is intended for use when doing HTTP PUT operations, as 
	 * loading the data into $this -> data could potentially be very expensive
	 * in terms of memory use.  For most other scenarios the other getters would
	 * normally be used.  
	 * 
	 * @link http://www.php.net/manual/en/function.fopen.php See the fopen documentation for details of valid $mode flags
	 * @param string $filename The filename to save the data under
	 * @param string $mode The mode flag to use on the target.  Identical to PHP fopen() mode flag.  Must be a node that allows writing to the file
	 * @return int Number of bytes written to disc 
	 */
	public function saveData ($filename, $mode = 'w')
	{
		$written	= 0;
		
		if (NULL === $this -> data)
		{
			$this -> data	= false;
			
			// Open files
			if ((false !== ($source = fopen (static::REQ_PATH, 'r')))
			&& (false !== ($target = fopen ($filename, $mode)))
			&& (flock ($target, LOCK_EX)))
			{
				// Copy input data to target file in 1K chunks
				while ($buffer = fread ($source, static::BUFFER_SIZE))
				{
					$written	+= fwrite ($target, $buffer);
				}
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
			// If the request body was already read into $this -> data then write that to disc
			$written	= file_put_contents ($filename, $this -> data, LOCK_EX);
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
		if ($this -> params === NULL)
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
}
