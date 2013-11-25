<?php

namespace gordian\reefknot\input\validate\prop;

/**
 * Test class for Required.
 * Generated by PHPUnit on 2011-12-11 at 10:09:45.
 */
class RequiredTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Required
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp ()
	{
		$this -> object = new Required;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown ()
	{
		
	}

	/**
	 * Test a true boolean passes as valid
	 */
	public function testIsValidBoolPasses ()
	{
		$this -> object -> setData (true);
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test a non-0 int passes as valid
	 */
	public function testIsValidIntPasses ()
	{
		$this -> object -> setData (42);
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test a non-0 float passes as valid
	 */
	public function testIsValidFloatPasses ()
	{
		$this -> object -> setData (pi ());
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test a non-empty string passes as valid
	 */
	public function testIsValidStringPasses ()
	{
		$this -> object -> setData ('The quick brown fox jumps over the lazy dog.');
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test a non-empty array passes as valid
	 */
	public function testIsValidArrayPasses ()
	{
		$this -> object -> setData (array (1, 2, 3, 4, 5));
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test a non-empty associative array passes as valid
	 */
	public function testIsValidAssocPasses ()
	{
		$this -> object -> setData (array ('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5));
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test an object value passes as valid
	 */
	public function testIsValidObjectPasses ()
	{
		$this -> object -> setData (new \stdClass ());
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test that NULL is treated as invalid
	 */
	public function testIsValidNullFails ()
	{
		$this -> object -> setData (NULL);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * Test that a false boolean is treated as invalid
	 */
	public function testIsValidBoolFalseFails ()
	{
		$this -> object -> setData (false);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * Test that a 0 value integer is treated as invalid
	 */
	public function testIsValidIntZeroFails ()
	{
		$this -> object -> setData (0);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * Test that a 0 value float is treated as invalid
	 */
	public function testIsValidFloatZeroFails ()
	{
		$this -> object -> setData (0.0);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * Test that an empty string is treated as invalid
	 */
	public function testIsValidStringEmptyFails ()
	{
		$this -> object -> setData ('');
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * Test that an empty array is treated as invalid
	 */
	public function testIsValidArrayEmptyFails ()
	{
		$this -> object -> setData (array ());
		$this -> assertFalse ($this -> object -> isValid ());
	}
}
