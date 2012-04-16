<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\http\iface\rest;

/**
 * REST object interface
 * 
 * This interface marks a class as being able to respond to REST HTTP requests.
 * NOTE: This interface should be considered an "abstract interface".  Classes
 * should not implement it directly, they should implement its sub-interfaces 
 * for the HTTP methods that you want your class to respond to. 
 * 
 * @author Gordon McVey
 */
interface Restable
{
}
