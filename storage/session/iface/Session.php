<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\storage\session\iface;

/**
 * Interface for ReefKnot session manager
 *
 * @author gordonmcvey
 */
interface Session
{
	/**
	 * Instantise a session
	 * 
	 * @param string $namespace
	 */
	public function __construct ($namespace);
}
