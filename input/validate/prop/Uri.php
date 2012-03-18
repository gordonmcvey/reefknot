<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\prop;

use
	gordian\reefknot\input\validate\abstr, 
	gordian\reefknot\input\validate\iface;

/**
 * Uri validation property
 * 
 * Validate that a valid URI/URL has been provided
 *
 * @author gordonmcvey
 */
class Uri extends abstr\Prop implements iface\Prop
{
	protected
		/**
		 * List of URL schema that will be considered valid
		 * 
		 * @var array 
		 */
		$schemaList	= array (
			'http',
			'https',
			'ftp', 
			'gopher'
		);
	
	/**
	 * Validate that this object's data is a valid URL/URI
	 * 
	 * This method depends on the underlying PHP filter_var function with the
	 * FILTER_VALIDATE_URL parameter.  As a consequence, there are some cases
	 * where the results may not be accurate
	 * 
	 * @return bool True if valid
	 * @throws \InvalidArgumentException 
	 * @todo using filter_var doesn't seem to be entirely reliable.  Look into more robust alternatives
	 */
	public function isValid ()
	{
		$valid	= false;
		$data	= $this -> getData ();
		
		switch (gettype ($data))
		{
			case 'NULL'		:
				$valid	= true;
			break;
			case 'string'	:
				if ((filter_var ($data, FILTER_VALIDATE_URL, array (
					FILTER_FLAG_SCHEME_REQUIRED, 
					FILTER_FLAG_HOST_REQUIRED
				))) !== false)
				{
					$parts	= parse_url ($data);
					$valid	= ((!empty ($parts ['scheme'])) 
							&& (in_array ($parts ['scheme'], $this -> schemaList)));
				}
			break;
			default			:
				throw new \InvalidArgumentException (__CLASS__ . ': This property cannot be applied to data of type ' . gettype ($data));
			break;
		}
		return ($valid);
	}
}
