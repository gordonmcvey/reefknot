<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\filter;

/**
 * Magic Quotes filter
 * 
 * This filter removes all "magic" slashes that may have been added to the 
 * input.  The drawbacks of Magic Quotes are well documented, so you normally
 * want to make sure that your input is free of magic quotes.  
 * 
 * This filter has no effect on PHP 5.4 (which no longer supports magic quotes)
 * or on intallations where magic_quotes_gpc has been disabled.  
 *
 * @author gordonmcvey
 */
class MagicQuotes extends abstr\Filter
{
	/**
	 * Check if filtering is needed
	 * 
	 * If magic_quotes_gpc is disabled, or the PHP version is 5.4 or greater
	 * then there is no need to apply this filter to the data.  
	 * 
	 * @return bool 
	 */
	protected function filterNeeded ()
	{
		var_dump (version_compare (PHP_VERSION, '5.4.0') <= 0);
		var_dump (get_magic_quotes_gpc () === 1);
		
		return ((version_compare (PHP_VERSION, '5.4.0') <= 0)
			&& (get_magic_quotes_gpc () === 1));
	}
	
	/**
	 * Apply the magic quotes stripping filter
	 * 
	 * @param mixed $data
	 * @return mixed 
	 */
	protected function applyFilter ($data = NULL)
	{
		if (!empty ($data))
		{
			$data	= is_array ($data)? 
				array_map (array ($this, 'applyFilter'), $data): 
				stripslashes ($data);
		}
		
		return ($data);
	}
	
	/**
	 * Strip magic quotes
	 * 
	 * @return mixed 
	 */
	public function filter ()
	{
		if ($this -> filterNeeded ())
		{
			$this -> data	= $this -> applyFilter ($this -> data);
		}
		
		return ($this -> data);
	}
}
