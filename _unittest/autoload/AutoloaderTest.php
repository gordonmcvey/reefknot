<?php

namespace gordian\reefknot\autoload;

use gordian\exampleclasses;

/**
 * Test class for Autoloader.
 * Generated by PHPUnit on 2011-12-17 at 18:10:33.
 */
class AutoloaderTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * @var gordian\reefknot\autoload\Autoloader
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp ()
	{
		// Disable the unit test autoloader for the duration of the following test
		global $unitTestAutoloader;
		$unitTestAutoloader -> unregister ();
		$this -> object = new Autoloader (__DIR__ . '/exampleclasses', 'gordian\exampleclasses');
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown ()
	{
		unset ($this -> object);
		// Restore normal autoloading when the test is done
		global $unitTestAutoloader;
		$unitTestAutoloader -> register ();
	}
	
	/**
	 * Test that the autoloader can be enabled
	 */
	public function testRegister ()
	{
		$arr	= array ($this -> object, 'load');
		$this -> object -> unregister ();
		$this -> assertFalse (in_array ($arr, spl_autoload_functions ()));
		$this -> object -> register ();
		$this -> assertTrue (in_array ($arr, spl_autoload_functions ()));
	}

	/**
	 * Test that the autoloader can be disabled
	 */
	public function testUnregister ()
	{
		$arr	= array ($this -> object, 'load');
		$this -> assertTrue (in_array ($arr, spl_autoload_functions ()));
		$this -> object -> unregister ();
		$this -> assertFalse (in_array ($arr, spl_autoload_functions ()));
	}
	
	/**
	 * Test that the autoloader can load classes in its namespace
	 */
	public function testAutoloadForClassPass ()
	{
		$this -> assertFalse (class_exists ('\gordian\exampleclasses\foo\FooClass', false));
		$this -> assertTrue (class_exists ('\gordian\exampleclasses\foo\FooClass', true));
		$a	= new exampleclasses\foo\FooClass ();
		$this -> assertInstanceOf ('\gordian\exampleclasses\foo\FooClass', $a);
	}
	
	/**
	 * Test that the autoloader can load interfaces in its namespace 
	 */
	public function testAutoloadForInterfacePass ()
	{
		$this -> assertFalse (interface_exists ('\gordian\exampleclasses\foo\FooInterface', false));
		$this -> assertTrue (interface_exists ('\gordian\exampleclasses\foo\FooInterface', true));
		$a	= $this -> getMock ('\gordian\exampleclasses\foo\FooInterface');
		$this -> assertInstanceOf ('\gordian\exampleclasses\foo\FooInterface', $a);
	}
	
	/**
	 * Test that the autoloader can load traits in its namespace
	 * 
	 * @requires PHP 5.4.0 
	 */
	public function testAutoloadForTraitPass ()
	{
		$this -> assertFalse (trait_exists ('\gordian\exampleclasses\foo\FooTrait', false));
		$this -> assertTrue (trait_exists ('\gordian\exampleclasses\foo\FooTrait', true));
		$this -> assertContains ('gordian\exampleclasses\foo\FooTrait', new exampleclasses\foo\FooTraitClient ());
	}
	
	/**
	 * Test that the autoloader can load classes that use a PEAR-style underscore psuedo-namespace
	 */
	public function testAutoloadForClassPearStylePass ()
	{
		unset ($this -> object);
		$this -> object = new Autoloader (__DIR__ . '/exampleclasses', 'gordian_exampleclasses', '_');
		$this -> assertFalse (class_exists ('\gordian_exampleclasses_baz_BazClass', false));
		$this -> assertTrue (class_exists ('\gordian_exampleclasses_baz_BazClass', true));
		$a	= new \gordian_exampleclasses_baz_BazClass ();
		$this -> assertInstanceOf ('\gordian_exampleclasses_baz_BazClass', $a);
	}
	
	/**
	 * Test that the autoloader can load interfaces that use a PEAR-style underscore psuedo-namespace
	 */
	public function testAutoloadForInterfacePearStylePass ()
	{
		unset ($this -> object);
		$this -> object = new Autoloader (__DIR__ . '/exampleclasses', 'gordian_exampleclasses', '_');
		$this -> assertFalse (interface_exists ('\gordian_exampleclasses_baz_BazInterface', false));
		$this -> assertTrue (interface_exists ('\gordian_exampleclasses_baz_BazInterface', true));
		$a	= $this -> getMock ('\gordian_exampleclasses_baz_BazInterface');
		$this -> assertInstanceOf ('\gordian_exampleclasses_baz_BazInterface', $a);
	}
	
	/**
	 * Test that the autoloader can load traits that use a PEAR-style underscore psuedo-namespace
	 * 
	 * @requires PHP 5.4.0
	 */
	public function testAutoloadForTraitPearStylePass ()
	{
		unset ($this -> object);
		$this -> object = new Autoloader (__DIR__ . '/exampleclasses', 'gordian_exampleclasses', '_');
		$this -> assertFalse (trait_exists ('\gordian_exampleclasses_baz_BazTrait', false));
		$this -> assertTrue (trait_exists ('\gordian_exampleclasses_baz_BazTrait', true));
		$this -> assertContains ('gordian_exampleclasses_baz_BazTrait', new exampleclasses\foo\FooTraitClient ());
	}
	
	/**
	 * Test that the autoloader behaves correctly when it can't find the 
	 * specified class file 
	 */
	public function testAutoloadFail ()
	{
		// Check the class doesn't already exist
		$this -> assertFalse (class_exists ('gordian\exampleclasses\quux\FarbleClass', false));
		// Check the class doesn't exist after an autoload attempt
		$this -> assertFalse (class_exists ('gordian\exampleclasses\quux\FarbleClass', true));
	}
	
	/**
	 * Test that the autoloader behaves correctly when looking for a class when 
	 * computing a path to include results in a file being included, but that 
	 * file not including the class that was requested
	 */
	public function testAutoloadFail2 ()
	{
		// Check the class doesn't already exist
		$this -> assertFalse (class_exists ('gordian\exampleclasses\bar\BarClass', false));
		// Check the class doesn't exist after an autoload attempt
		$this -> assertFalse (class_exists ('gordian\exampleclasses\bar\BarClass', true));
		// Check that doing another class_exists on the same class doesn't cause the script to fail
		$this -> assertFalse (class_exists ('gordian\exampleclasses\bar\BarClass', true));
	}
}
