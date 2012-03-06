<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\storage\iface;

/**
 * CRUD (Create/Read/Update/Delete) interface for objects that store data
 * 
 * @author gordonmcvey
 */
interface Crud
{
	/**
	 * @param mixed $data 
	 * @param string $key
	 * @return Crud
	 */
	public function createItem ($data, $key);
	
	/**
	 * @param string $key
	 * @return Crud
	 */
	public function readItem ($key);
	
	/**
	 * @param mixed $data 
	 * @param string $key
	 * @return Crud
	 */
	public function updateItem ($data, $key);
	
	/**
	 * @param string $key
	 * @return Crud
	 */
	public function deleteItem ($key);
}
