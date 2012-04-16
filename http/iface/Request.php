<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\http\iface;

/**
 * HTTP Request object interface
 * 
 * @author Gordon McVey
 */
interface Request
{
	const
		M_CONNECT	= 'CONNECT',
		M_DELETE	= 'DELETE',
		M_GET		= 'GET',
		M_HEAD		= 'HEAD',
		M_OPTIONS	= 'OPTIONS',
		M_POST		= 'POST',
		M_POT		= 'PUT',
		M_TRACE		= 'TRACE';
	
	public function isConnect ();
	public function isDelete ();
	public function isGet ();
	public function isHead ();
	public function isOptions ();
	public function isPost ();
	public function isPut ();
	public function isTrace ();
}
