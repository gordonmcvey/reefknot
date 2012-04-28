<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\di\iface;

/**
 * Dependency Injection container interface
 * 
 * This interface specifies the protocol that the framework expects a Dependency
 * Injection container to have.  If you want to replace the framework's 
 * implementation with your own, then you should declare that your replacement 
 * implements this interface.  You will then be able to use your own container
 * as a drop-in replacement for the provided implementation.  You can also 
 * subclass the framework's implementation if you need something basically
 * similar, but with additional behaviour. 
 *
 * @author Gordon McVey
 * @category Reefknot
 * @package DependencyInjection
 * @subpackage Interfaces
 */
interface Container
{
	public function __set ($key, $value);
	public function __get ($key);
	public function single (\Closure $callable);
}
