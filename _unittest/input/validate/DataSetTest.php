<?php

namespace gordian\reefknot\input\validate;

/**
 * Test class for DataSet.
 * Generated by PHPUnit on 2011-12-17 at 18:10:34.
 */
class DataSetTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var gordian\reefknot\input\validate\DataSet
	 */
	protected $object;

	/**
	 * Helper for building mocks
	 * 
	 * @param string Fully namespaced class of item ot mock
	 * @param mixed $value
	 * @param bool $isValid
	 * @return Object 
	 */
	protected function makeStub ($type, $value = NULL, $isValid = true)
	{
		$stub = $this -> getMockBuilder ($type)
			-> disableOriginalConstructor ()
			-> getMock ();

		$stub -> expects ($this -> any ())
			-> method ('setData')
			-> will ($this -> returnValue ($stub));

		$stub -> expects ($this -> any ())
			-> method ('getData')
			-> will ($this -> returnValue ($value));

		$stub -> expects ($this -> any ())
			-> method ('isValid')
			-> will ($this -> returnValue ($isValid));

		return ($stub);
	}

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp ()
	{
		$arrMock = $this -> getMock ('\gordian\reefknot\input\validate\type\IsArray');
		$this -> object = new DataSet ($arrMock);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown ()
	{
		
	}

	/**
	 * Test that fields can be added to the DataSet 
	 */
	public function testAddField ()
	{
		$field = $this -> getMock ('\gordian\reefknot\input\validate\iface\Field');
		$this -> assertEmpty ($this -> object -> getFields ());
		$this -> object -> addField ('testfield', $field);
		$this -> assertNotEmpty ($this -> object -> getFields ());
		$this -> assertTrue (array ('testfield' => $field) === $this -> object -> getFields ());
	}

	/**
	 * Test that adding the same field to the dataset more than once throws an exception 
	 */
	public function testAddFieldThrowsException ()
	{
		$exception = NULL;
		$field = $this -> getMock ('\gordian\reefknot\input\validate\iface\Field');

		try
		{
			$this -> object -> addField ('testfield', $field)
				-> addField ('testfield2', $field);
		}
		catch (\Exception $e)
		{
			$exception = $e;
		}

		$this -> assertInstanceOf ('\InvalidArgumentException', $exception);
		$this -> assertTrue (array ('testfield' => $field) === $this -> object -> getFields ());
	}

	/**
	 * Test that we can retrieve stored fields from the dataset 
	 */
	public function testGetField ()
	{
		$this -> object -> addField ('field1', $this -> getMock ('\gordian\reefknot\input\validate\iface\Field'))
			-> addField ('field2', $this -> getMock ('\gordian\reefknot\input\validate\iface\Field'))
			-> addField ('field3', $this -> getMock ('\gordian\reefknot\input\validate\iface\Field'));

		$this -> assertInstanceOf ('\gordian\reefknot\input\validate\iface\Field', $this -> object -> getField ('field2'));
		$this -> assertNull ($this -> object -> getField ('field4'));
	}

	/**
	 * Test that we can remove fields from the instance
	 */
	public function testDeleteField ()
	{
		$field = $this -> getMock ('\gordian\reefknot\input\validate\iface\Field');
		$this -> assertInstanceOf ('\gordian\reefknot\input\validate\iface\Field', $field);
		$this -> object -> addField ('testfield', $field);
		$this -> assertNotEmpty ($this -> object -> getFields ());
		$this -> object -> deleteField ('testfield');
		$this -> assertEmpty ($this -> object -> getFields ());
	}

	/**
	 * Test that we get a complete and correct list of fields
	 */
	public function testGetFields ()
	{
		$fields = array (
			'field1' => $this -> getMock ('\gordian\reefknot\input\validate\iface\Field'),
			'field2' => $this -> getMock ('\gordian\reefknot\input\validate\iface\Field'),
			'field3' => $this -> getMock ('\gordian\reefknot\input\validate\iface\Field')
		);

		foreach ($fields as $key => $field)
		{
			$this -> object -> addField ($key, $field);
		}

		$this -> assertTrue ($this -> object -> getFields () === $fields);
	}

	/**
	 * Test that data is being stored properly in the instance
	 */
	public function testSetData ()
	{
		$this -> object -> addField ('test', $this -> getMock ('\gordian\reefknot\input\validate\iface\Field'));
		$this -> object -> setData ('test');
		$this -> assertEquals ('test', $this -> object -> getData ());
		$this -> object -> setData (pi ());
		$this -> assertEquals (pi (), $this -> object -> getData ());
		$this -> object -> setData (array (1, 3, 5));
		$this -> assertEquals (array (1, 3, 5), $this -> object -> getData ());
	}

	/**
	 * Test that validation passes if the given data is NULL
	 */
	public function testIsValidNullPasses ()
	{
		// We're using a real IsArray type object here
		$this -> object -> setType (new type\IsArray ());
		$this -> object -> setData (NULL);
		$this -> assertTrue ($this -> object -> isValid ());
	}

	/**
	 * Test that validation passes if the data given is an array 
	 */
	public function testIsValidArrayPasses ()
	{
		// We're using a real IsArray type object here
		$this -> object -> setType (new type\IsArray ());
		$this -> object -> setData (array ('foo' => 1, 'bar' => 2, 'baz' => 3));
		$this -> assertTrue ($this -> object -> isValid ());
	}

	/**
	 * Test that validation passes if the data given is an empty array 
	 */
	public function testIsValidEmptyArrayPasses ()
	{
		// We're using a real IsArray type object here
		$this -> object -> setType (new type\IsArray ())
			-> setData (array ());
		$this -> assertTrue ($this -> object -> isValid ());
	}

	/**
	 * Test that validation fails when attempting to pass in a non-array 
	 */
	public function testIsValidNotArrayFails ()
	{
		// We're using a real IsArray type object here
		$this -> object -> setType (new type\IsArray ());
		$this -> object -> setData (new \stdClass ());
		$this -> assertFalse ($this -> object -> isValid ());
		$this -> assertEquals ($this -> object -> getInvalids (), array ('gordian\reefknot\input\validate\type\IsArray'));
		$this -> object -> setData (123);
		$this -> assertFalse ($this -> object -> isValid ());
		$this -> assertEquals ($this -> object -> getInvalids (), array ('gordian\reefknot\input\validate\type\IsArray'));
		$this -> object -> setData ('The quick brown fox jumps over the lazy dog.');
		$this -> assertFalse ($this -> object -> isValid ());
		$this -> assertEquals ($this -> object -> getInvalids (), array ('gordian\reefknot\input\validate\type\IsArray'));
	}

	public function testIsValidFieldsPass ()
	{
		// We're using a real IsArray type object here
		$this -> object -> setType (new type\IsArray ())
			-> addField ('foo', $this -> makeStub ('\gordian\reefknot\input\validate\iface\Field'))
			-> addField ('bar', $this -> makeStub ('\gordian\reefknot\input\validate\iface\Field'))
			-> addField ('baz', $this -> makeStub ('\gordian\reefknot\input\validate\iface\Field'))
			-> setData (array ('foo' => 1, 'bar' => 2, 'baz' => 3));

		$this -> assertTrue ($this -> object -> isValid ());
	}
	
	public function testIsValidInvalidFieldFails ()
	{
		$this -> object -> setType (new type\IsArray ())
			-> addField ('foo', $this -> makeStub ('\gordian\reefknot\input\validate\iface\Field'))
			-> addField ('bar', $this -> makeStub ('\gordian\reefknot\input\validate\iface\Field', NULL, false))
			-> addField ('baz', $this -> makeStub ('\gordian\reefknot\input\validate\iface\Field'))
			-> setData (array ('foo' => 1, 'bar' => 2, 'baz' => 3));

		$this -> assertFalse ($this -> object -> isValid ());
		$this -> assertTrue (array_key_exists ('bar', $this -> object -> getInvalids ()));
	}
}
