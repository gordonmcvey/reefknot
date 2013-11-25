<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\input\validate\iface;

/**
 * Globalized Data Set interface
 * 
 * @author Gordon McVey
 * @category Reefknot
 * @package gordian\reefknot\input\validate\iface
 */
interface DataSetGlobalized extends DataSet
{
	/**
	 * Add a global property
	 * 
	 * Global properties allow the same validation rule to be applied to all 
	 * fields within the DataSet.  This is useful when you are expecting your 
	 * data to all be of a uniform format. 
	 * 
	 * @param Prop $newProp
	 * @return DataSetGlobalized
	 */
	public function addGlobalProp (Prop $newProp);
	
	/**
	 * Remove the named global property 
	 *
	 * @param string $propName
	 * @return DataSetGlobalized
	 */
	public function deleteGlobalProp ($propName);
	
	/**
	 * Get the global preperties
	 * 
	 * @return array 
	 */
	public function getGlobalProps ();
	
	/**
	 * Set the global data type 
	 *
	 * @param Type $type
	 * @return DataSetGlobalized
	 */
	public function setGlobalType (Type $type);
	
	/**
	 * @return Type 
	 */
	public function getGlobalType ();
	
	/**
	 * @return array 
	 */
	public function getGlobalRules ();
	
	/**
	 * @return array 
	 */
	public function getGlobalInvalids ();
}
