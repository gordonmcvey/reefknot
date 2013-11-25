<?php

namespace gordian\reefknot\input\validate\prop;

function alwaysTrue ($data)
{
	return (true);
}

function alwaysFalse ($data)
{
	return (false);
}

function withArgs ($data, $arg1, $arg2)
{
	return (($arg1 == 1) && ($arg2 == 2) && ($data == ($arg1 + $arg2)));
}

class Callbacks
{
	static public function alwaysTrue ($data)
	{
		return (true);
	}
	
	static public function alwaysFalse ($data)
	{
		return (false);
	}
	
	public function instanceTrue ($data)
	{
		return (true);
	}
	
	public function instanceFalse ($false)
	{
		return (false);
	}
}

/**
 * Test class for Callback.
 * Generated by PHPUnit on 2012-01-01 at 13:59:48.
 */
class CallbackTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var gordian\reefknot\input\validate\prop\Callback
	 */
	protected $object;
	
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp ()
	{
		$this -> object = new Callback (array ('callback' => __NAMESPACE__ . '\alwaysTrue'));
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown ()
	{
		
	}
	
	/**
	 * Test that NULL always passes
	 */
	public function testIsValidNullPasses ()
	{
		$this -> object	-> setData (NULL);
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test that validation passes if the callback returns true
	 */
	public function testIsValidFunctionTruePasses ()
	{
		$cfg	= array (
			'callback'	=> __NAMESPACE__ . '\alwaysTrue'
		);
		
		$this -> object	-> setConfig ($cfg) 
						-> setData (123);
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test that validation always fails if the callback returns false
	 */
	public function testIsValidFunctionFalseFails ()
	{
		$cfg	= array (
			'callback'	=> __NAMESPACE__ . '\alwaysFalse'
		);
		
		$this -> object	-> setConfig ($cfg) 
						-> setData (123);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * Test that an anonymous function that returns true always causes validation to pass
	 */
	public function testIsValidAnonTruePasses ()
	{
		$cfg	= array (
			'callback'	=> function () { return (true);}
		);
		
		$this -> object	-> setConfig ($cfg) 
						-> setData (123);
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test that an anonymous function that returns false always causes validation to vail
	 */
	public function testIsValidAnonFalseFails ()
	{
		$cfg	= array (
			'callback'	=> function () { return (false);}
		);
		
		$this -> object	-> setConfig ($cfg) 
						-> setData (123);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * Test that using a static function that always returns true causes validation to always pass
	 */
	public function testIsValidStaticTruePasses ()
	{
		$cfg	= array (
			'callback'	=> __NAMESPACE__ . '\Callbacks::alwaysTrue'
		);
		
		$this -> object	-> setConfig ($cfg) 
						-> setData (123);
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test that using a static function that always returns false causes validation to always fail
	 */
	public function testIsValidStaticFalseFails ()
	{
		$cfg	= array (
			'callback'	=> __NAMESPACE__ . '\Callbacks::alwaysFalse'
		);
		
		$this -> object	-> setConfig ($cfg) 
						-> setData (123);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * Check always pass static method with alternative calling convention
	 */
	public function testIsValidStaticTruePasses2 ()
	{
		$cfg	= array (
			'callback'	=> array (__NAMESPACE__ . '\Callbacks', 'alwaysTrue')
		);
		
		$this -> object	-> setConfig ($cfg) 
						-> setData (123);
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Check always fail static method with alternative calling convention
	 */
	public function testIsValidStaticFalseFails2 ()
	{
		$cfg	= array (
			'callback'	=> array (__NAMESPACE__ . '\Callbacks', 'alwaysFalse')
		);
		
		$this -> object	-> setConfig ($cfg) 
						-> setData (123);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * Test instance method that always returns true makes validation pass
	 */
	public function testIsValidInstanceTruePasses ()
	{
		$obj	= new Callbacks;
		$cfg	= array (
			'callback'	=> array ($obj, 'instanceTrue')
		);
		
		$this -> object	-> setConfig ($cfg) 
						-> setData (123);
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test instance method that always returns false makes validation fail
	 */
	public function testIsValidInstanceFalseFails ()
	{
		$obj	= new Callbacks;
		$cfg	= array (
			'callback'	=> array ($obj, 'instanceFalse')
		);
		
		$this -> object	-> setConfig ($cfg) 
						-> setData (123);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * Test a callback function can be passed arguments that will affect the validation outcome
	 */
	public function testIsValidWithArgsTruePasses ()
	{
		$cfg	= array (
			'callback'	=> __NAMESPACE__ . '\withArgs',
			'args'		=> array (1, 2)
		);
		
		$this -> object	-> setConfig ($cfg) 
						-> setData (3);
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	/**
	 * Test a callback function can be passed arguments that will affect the validation outcome
	 */
	public function testIsValidWithArgsFalseFails ()
	{
		$cfg	= array (
			'callback'	=> __NAMESPACE__ . '\withArgs',
			'args'		=> array (2, 1)
		);
		
		$this -> object	-> setConfig ($cfg) 
						-> setData (3);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	/**
	 * 
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetConfigEmptyThrowsException ()
	{
		$cfg		= array ();
		$this -> object -> setConfig ($cfg);
	}
	
	/**
	 * 
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetConfigNoPropsThrowsException ()
	{
		$cfg		= array ('foo' => 'bar');
		$this -> object -> setConfig ($cfg);
	}
	
	/**
	 * 
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetConfigInvalidPropsThrowsException ()
	{
		$cfg		= array ('callback' => pi ());
		$this -> object -> setConfig ($cfg);
	}
	
	/**
	 * 
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetConfigInvalidPropsThrowsException2 ()
	{
		$cfg		= array (
			'callback'	=> __NAMESPACE__ . '\alwaysFalse',
			'args'		=> pi ()
		);
		$this -> object -> setConfig ($cfg);
	}
	
	public function testSetConfigPasses ()
	{
		$cfg		= array (
			'callback'	=> __NAMESPACE__ . '\alwaysFalse',
		);
		$this -> object -> setConfig ($cfg);
		$this -> assertSame ($this -> object -> getConfig (), $cfg);
	}
	
	public function testSetConfigPasses2 ()
	{
		$cfg		= array (
			'callback'	=> __NAMESPACE__ . '\withArgs',
			'args'		=> array (2, 1)
		);
		$this -> object -> setConfig ($cfg);
		$this -> assertTrue ($this -> object -> getConfig () == $cfg);
	}
}
