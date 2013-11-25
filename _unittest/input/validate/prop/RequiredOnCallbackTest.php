<?php

namespace gordian\reefknot\input\validate\prop;

/* Simple callbacks for testing */
function roc_alwaysTrue () { return true; }
function roc_alwaysFalse () { return false; }
function roc_argSet ($arg = NULL) { return (isset ($arg)); }

class CallbackSuite
{
	public static function staticCallback ()
	{
		
	}
	
	public function instanceCallback ()
	{
		
	}
}

/**
 * Test class for RequiredOnCallback.
 * Generated by PHPUnit on 2012-04-04 at 19:17:38.
 */
class RequiredOnCallbackTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var RequiredOnCallback
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp ()
	{
		$this -> object = new RequiredOnCallback (array ('callback' => '\gordian\reefknot\input\validate\prop\roc_alwaysTrue'));
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown ()
	{
		
	}

	/**
	 */
	public function testSetConfigNoConfigThrowsException ()
	{
		$exception	= NULL;
		$cfg		= array ();
		
		try
		{
			$this -> object -> setConfig ($cfg);
		}
		catch (\Exception $e)
		{
			$exception	= $e;
		}
		
		$this -> assertInstanceOf ('\InvalidArgumentException', $exception);
		$this -> assertFalse ($this -> object -> getConfig () === $cfg);
	}
	
	public function testSetConfigNoCallbackThrowsException ()
	{
		$exception	= NULL;
		$cfg		= array (
			'callback'	=> array ()
		);
		
		try
		{
			$this -> object -> setConfig ($cfg);
		}
		catch (\Exception $e)
		{
			$exception	= $e;
		}
		
		$this -> assertInstanceOf ('\InvalidArgumentException', $exception);
		$this -> assertFalse ($this -> object -> getConfig () === $cfg);
	}
	
	public function testSetConfigInvalidArgsThrowsException ()
	{
		$exception	= NULL;
		$cfg		= array (
			'callback'	=> '\gordian\reefknot\input\validate\prop\roc_argSet',
			'args'		=> NULL
		);
		
		try
		{
			$this -> object -> setConfig ($cfg);
		}
		catch (\Exception $e)
		{
			$exception	= $e;
		}
		
		$this -> assertInstanceOf ('\InvalidArgumentException', $exception);
		$this -> assertFalse ($this -> object -> getConfig () === $cfg);
	}
	
	public function testSetConfigInvalidArgsThrowsException2 ()
	{
		$exception	= NULL;
		$cfg		= array (
			'callback'	=> '\gordian\reefknot\input\validate\prop\roc_argSet',
			'args'		=> 12345
		);
		
		try
		{
			$this -> object -> setConfig ($cfg);
		}
		catch (\Exception $e)
		{
			$exception	= $e;
		}
		
		$this -> assertInstanceOf ('\InvalidArgumentException', $exception);
		$this -> assertFalse ($this -> object -> getConfig () === $cfg);
	}
	
	public function testSetConfigValid ()
	{
		$exception	= NULL;
		$cfg		= array (
			'callback'	=> '\gordian\reefknot\input\validate\prop\roc_argSet',
			'args'		=> array (1)
		);
		
		try
		{
			$this -> object -> setConfig ($cfg);
		}
		catch (\Exception $e)
		{
			$exception	= $e;
		}
		
		$this -> assertNull ($exception);
		$this -> assertTrue ($this -> object -> getConfig () === $cfg);
	}

	public function testSetConfigValid2 ()
	{
		$exception	= NULL;
		$cfg		= array (
			'callback'	=> function () {}
		);
		
		try
		{
			$this -> object -> setConfig ($cfg);
		}
		catch (\Exception $e)
		{
			$exception	= $e;
		}
		
		$this -> assertNull ($exception);
		$this -> assertTrue ($this -> object -> getConfig () === $cfg);
	}
	
	public function testSetConfigValid4 ()
	{
		$exception	= NULL;
		$cfg		= array (
			'callback'	=> array ('\gordian\reefknot\input\validate\prop\CallbackSuite', 'staticCallback')
		);
		
		try
		{
			$this -> object -> setConfig ($cfg);
		}
		catch (\Exception $e)
		{
			$exception	= $e;
		}
		
		$this -> assertNull ($exception);
		$this -> assertTrue ($this -> object -> getConfig () === $cfg);
	}
	
	public function testSetConfigValid3 ()
	{
		$exception	= NULL;
		$cfg		= array (
			'callback'	=> '\gordian\reefknot\input\validate\prop\CallbackSuite::staticCallback'
		);
		
		try
		{
			$this -> object -> setConfig ($cfg);
		}
		catch (\Exception $e)
		{
			$exception	= $e;
		}
		
		$this -> assertNull ($exception);
		$this -> assertTrue ($this -> object -> getConfig () === $cfg);
	}
	
	public function testSetConfigValid5 ()
	{
		$exception	= NULL;
		$cfg		= array (
			'callback'	=> array (new CallbackSuite, 'instanceCallback')
		);
		
		try
		{
			$this -> object -> setConfig ($cfg);
		}
		catch (\Exception $e)
		{
			$exception	= $e;
		}
		
		$this -> assertNull ($exception);
		$this -> assertTrue ($this -> object -> getConfig () === $cfg);
	}
	
	/**
	 */
	public function testIsValidAlwaysTruePass ()
	{
		$this -> object -> setData ('123');
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	public function testIsValidAlwaysTrueFail ()
	{
		$this -> object -> setData (0);
		$this -> assertFalse ($this -> object -> isValid ());
		$this -> object -> setData ('');
		$this -> assertFalse ($this -> object -> isValid ());
		$this -> object -> setData (false);
		$this -> assertFalse ($this -> object -> isValid ());
		$this -> object -> setData (array ());
		$this -> assertFalse ($this -> object -> isValid ());
		$this -> object -> setData (NULL);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	public function testIsValidAlwaysFalsePass ()
	{
		$this -> object -> setConfig (array ('callback' => '\gordian\reefknot\input\validate\prop\roc_alwaysFalse'));
		$this -> object -> setData ('123');
		$this -> assertTrue ($this -> object -> isValid ());
		$this -> object -> setData (0);
		$this -> assertTrue ($this -> object -> isValid ());
		$this -> object -> setData ('');
		$this -> assertTrue ($this -> object -> isValid ());
		$this -> object -> setData (false);
		$this -> assertTrue ($this -> object -> isValid ());
		$this -> object -> setData (array ());
		$this -> assertTrue ($this -> object -> isValid ());
		$this -> object -> setData (NULL);
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	public function testIsValidArgSetPass ()
	{
		$this -> object -> setConfig (array ('callback' => '\gordian\reefknot\input\validate\prop\roc_argSet', 'args' => array (true)));
		$this -> object -> setData ('123');
		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	public function testIsValidArgSetFail ()
	{
		$this -> object -> setConfig (array ('callback' => '\gordian\reefknot\input\validate\prop\roc_argSet', 'args' => array (true)));
		$this -> object -> setData (0);
		$this -> assertFalse ($this -> object -> isValid ());
		$this -> object -> setData ('');
		$this -> assertFalse ($this -> object -> isValid ());
		$this -> object -> setData (false);
		$this -> assertFalse ($this -> object -> isValid ());
		$this -> object -> setData (array ());
		$this -> assertFalse ($this -> object -> isValid ());
		$this -> object -> setData (NULL);
		$this -> assertFalse ($this -> object -> isValid ());
	}
	
	public function testIsValidArgSetPass2 ()
	{
		$this -> object -> setConfig (array ('callback' => '\gordian\reefknot\input\validate\prop\roc_argSet', 'args' => array (NULL)));
		$this -> object -> setData ('123');
		$this -> assertTrue ($this -> object -> isValid ());
		$this -> object -> setData (0);
		$this -> assertTrue ($this -> object -> isValid ());
		$this -> object -> setData ('');
		$this -> assertTrue ($this -> object -> isValid ());
		$this -> object -> setData (false);
		$this -> assertTrue ($this -> object -> isValid ());
		$this -> object -> setData (array ());
		$this -> assertTrue ($this -> object -> isValid ());
		$this -> object -> setData (NULL);
		$this -> assertTrue ($this -> object -> isValid ());
	}
}
