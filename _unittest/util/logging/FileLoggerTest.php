<?php

namespace gordian\reefknot\util\logging;

require_once dirname (__FILE__) . '/../../../util/logging/FileLogger.php';

/**
 * Test class for FileLogger.
 * Generated by PHPUnit on 2012-01-21 at 18:05:10.
 */
class FileLoggerTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var FileLogger
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp ()
	{
		$this -> object = new FileLogger;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown ()
	{
		
	}

	/**
	 * @covers {className}::{origMethodName}
	 * @todo Implement testUpdate().
	 */
	public function testUpdate ()
	{
		// Remove the following lines when you implement this test.
		$this -> markTestIncomplete (
			'This test has not been implemented yet.'
		);
	}

}

?>
