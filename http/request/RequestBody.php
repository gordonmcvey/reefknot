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
 * @author Gordon McVey
 * @category Reefknot
 * @package HTTP
 * @subpackage Request
 */
class RequestBody implements iface\RequestBody
{
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
	 * @return mixed 
	 */
	public function getData ()
	{
		if ($this -> data === NULL)
		{
			$this -> data	= false;
			if (($h = fopen ('php://input', 'r')) !== false)
			{
				while ($buffer = fread ($h, 1024))
				{
					$this -> data	.= $buffer;
				}
				fclose ($h);
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
	 * @param string $filename
	 * @param string $mode
	 * @return int Number of bytes written to disc 
	 */
	public function saveData ($filename)
	{
		$written	= 0;
		
		if ($this -> data === NULL)
		{
			$this -> data	= false;
			
			// Open files
			if ((($sh = fopen ('php://input', 'r')) !== false)
			&& (($th = fopen ($filename, 'w')) !== false)
			&& (flock ($th, LOCK_EX)))
			{
				// Copy input data to target file in 1K chunks
				while ($buffer = fread ($sh, 1024))
				{
					$written	+= fwrite ($th, $buffer);
				}
			}
			
			// Clean up target file
			if ((isset ($th)) && ($th))
			{
				flock ($th, LOCK_UN);
				fclose ($th);				
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
	 * @return array 
	 */
	public function getAsParams ()
	{
		if ($this -> dataAsParams === NULL)
		{
			parse_str ($this -> getData (), $this -> dataAsParams);
		}
		return $this -> dataAsParams;
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
			
		if (($data = $this -> getParams ())
		&& (array_key_exists ($key, $data)))
		{
			$val	= $data [$key];
		}
		
		return $val;
	}
}
