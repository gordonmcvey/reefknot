<?php

namespace gordian\reefknot\input\validate\prop;

/**
 * Test class for Uri.
 * Generated by PHPUnit on 2011-12-13 at 12:37:27.
 */
class UriTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var gordian\reefknot\input\validate\prop\Uri
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp ()
	{
		$this -> object = new Uri;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown ()
	{
		
	}
	
	/**
	 * Test NULL passes validation
	 */
	public function testIsValidNullPasses ()
	{
		$this -> object -> setData (NULL);
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test a typical URL with a trailing slash for the root path
	 */
	public function testIsValidPass ()
	{
		$this -> object -> setData ('http://localhost/');
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test a typical URL without a trailing slash for the root path
	 */
	public function testIsValidPass2 ()
	{
		$this -> object -> setData ('http://localhost');
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test a HTTPS URL
	 */
	public function testIsValidPass3 ()
	{
		$this -> object -> setData ('https://localhost');
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test a typical URL
	 */
	public function testIsValidPass4 ()
	{
		$this -> object -> setData ('http://www.example.com/');
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test that URLs with hyphens in them can be validated
	 */
	public function testIsValidPass6 ()
	{
		$this -> object -> setData ('http://www.example-site.com/');
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test that we can validate URLs with less-common TLDs
	 */
	public function testIsValidPass7 ()
	{
		$this -> object -> setData ('http://www.example.museum/');
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test that we can validate a URL with an IPv4 address
	 */
	public function testIsValidPass8 ()
	{
		$this -> object -> setData ('http://127.0.0.1');
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test that we can validate a URL with an IPv6 address
	 */
	public function testIsValidPass9 ()
	{
		$this -> markTestSkipped ('We need to find a way of validating IPv6 URLs');
		$this -> object -> setData ('http://[0:0:0:0:0:0:0:1]');
		$this -> assertTrue ($this -> object -> isValid ());
	}

	/**
	 * Empty strings are not valid URLs
	 */
	public function testIsValidFail ()
	{
		$this -> object -> setData ('');
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * URLs with an empty schema are invalid
	 */
	public function testIsValidFail2 ()
	{
		$this -> object -> setData ('://localhost');
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * URLs with unknown schema are invalid
	 */
	public function testIsValidFail3 ()
	{
		$this -> object -> setData ('foo://localhost');
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * URLs without a schema are invalid
	 */
	public function testIsValidFail5 ()
	{
		$this -> object -> setData ('www.example.com');
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * URLs with underscores in the host name are invalid
	 */
	public function testIsValidFail4 ()
	{
		$this -> object -> setData ('http://www.example_site.com/');
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * Test that anything other than a string causes an execpt to be thrown
	 * 
	 * @expectedException \InvalidArgumentException
	 */
	public function testIsValidWrongTypeThrowsException ()
	{
		$this -> object -> setData (new \stdClass ());
		$this -> object -> isValid ();
	}
}
