<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\http\abstr\rest;

use 
	gordian\reefknot\http\iface;

/**
 * Description of Restful
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package HTTP
 * @subpackage REST
 */
abstract class Restful implements iface\rest\Restful
{
	/**
	 * Test whether an instance of this object can support the type of request
	 * made in the given Request object. 
	 * 
	 * This is a very basic implementation of the supportsMethod method for the 
	 * Restful interface.  It checks if the target class (the instance) has 
	 * a method defined to deal with requests that use the HTTP verb given in 
	 * the request object.  
	 * 
	 * In real world use cases your resource will almost certainly want to be 
	 * a lot more sophiscated than this.  For example, you might only allow a
	 * request to GET a rewource if the request was made by an authenticated 
	 * user of the system with access rights to the resource in question.  In 
	 * that case, simply checking for support for GET will almost certainly be
	 * insfficant.  In the case of a Gettable object that needs access control
	 * you can either implement access control checking in the httpGet() method
	 * of the target object, or you can extend this method in the subclass with
	 * access control functionality.  
	 * 
	 * Additionally, as most browsers only support GET and POST when making 
	 * "normal" (non-AJAX) requests, you might also want to extend this method
	 * to incorporate checking for a hidden field to let you override the HTTP
	 * verb with one of your own
	 * 
	 * @param iface\Request $request
	 * @return bool True if supported 
	 */
	public function supportsMethod (iface\Request $request)
	{
		$supported	= false;
		
		// Test that this object implements the method needed to deal with this request
		switch (strval ($request -> getMethod ()))
		{
			case $request::M_CONNECT	:
				$supported	= $this instanceof iface\rest\Connectable;
			break;
			case $request::M_DELETE		:
				$supported	= $this instanceof iface\rest\Deleteable;
			break;
			// Objects that respond to GET must also respond to HEAD
			case $request::M_GET		:
			case $request::M_HEAD		:
				$supported	= $this instanceof iface\rest\Gettable;
			break;
			case $request::M_OPTIONS	:
				$supported	= $this instanceof iface\rest\Optionsable;
			break;
			case $request::M_POST		:
				$supported	= $this instanceof iface\rest\Postable;
			break;
			case $request::M_POT		:
				$supported	= $this instanceof iface\rest\Puttable;
			break;
			case $request::M_TRACE		:
				$supported	= $this instanceof iface\rest\Traceable;
			break;
		}
		
		return ($supported);
	}
}
