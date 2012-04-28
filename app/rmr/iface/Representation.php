<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\app\rmr\iface;

use
	gordian\reefknot\http\iface;

/**
 * Representation interface
 * 
 * A Representation is how the results of a request are presented to the user. 
 * They can be thought of as being somewhat similar to a View in an MVC 
 * architecture, though a Representation is intended to be a lot more flexible
 * than a View.  The same activity can result in a different Representation 
 * being returned (for example a request that would normally return a web page
 * could instead return a JSON representation if the request indicates that it 
 * was made through an XMLHttpRequest implementation.  
 * 
 * The Representation takes a Resource and a Request, and uses them to build an
 * approporiate body for sending along with the Response.  This can be as simple
 * as just returning a value directly from the Resource, or it may involve 
 * interactions with multiple business objects and the use of a templateing 
 * engine, a DOMDocument object or anything else that generates an output. 
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package Application
 * @subpackage RMR
 * @subpackage Interfaces
 */
interface Representation
{
}
