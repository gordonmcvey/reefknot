<?php

namespace gordian\reefknot\input\validate\type;

/**
 * Test class for IsArray.
 * Generated by PHPUnit on 2011-12-04 at 19:46:55.
 */
class IsArrayTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var IsArray
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp ()
	{
		$this -> object = new IsArray;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown ()
	{
		unset ($this -> ojbect);
	}

	public function testIsValidNullPass ()
	{
		$this -> object -> setData (NULL);
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	public function testIsValidArrayPass ()
	{
		$this -> object -> setData (array (1, 2, 3, 4, 5));
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	public function testIsValidAssocPass ()
	{
		$this -> object -> setData (array ('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5));
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	//public function testIsValidArrayAccessPass ()
	//{
	//	$this -> object -> setData ($this -> getMock ('\ArrayAccess'));
	//	$this -> assertTrue ($this -> object -> isValid ());
	//}
	
	public function testIsValidBoolFail ()
	{
		$this -> object -> setData (true);
		$this -> assertFalse ($this -> object -> isValid ());
		$this -> object -> setData (false);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	public function testIsValidFloatFail ()
	{
		$this -> object -> setData (pi ());
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	public function testIsValidIntFail ()
	{
		$this -> object -> setData (42);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	public function testIsValidObjectFail ()
	{
		$this -> object -> setData (new \StdClass ());
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	public function testIsValidStringFail ()
	{
		$this -> object -> setData ('The quick brown fox jumps over the lazy dog.');
		$this -> assertFalse ($this -> object -> isValid ());
	}
}
