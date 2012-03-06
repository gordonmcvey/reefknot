<?php

namespace gordian\reefknot\input\validate\type;

require_once dirname (__FILE__) . '/../../../../input/validate/type/IsMixed.php';

/**
 * Test class for IsMixed.
 * Generated by PHPUnit on 2011-12-10 at 16:55:08.
 */
class IsMixedTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var IsMixed
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp ()
	{
		$this -> object = new IsMixed;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown ()
	{
		
	}

	public function testIsValid ()
	{
		$this -> object -> setData (new \stdClass ());
		$this -> assertTrue ($this -> object -> isValid ());
	}
}
