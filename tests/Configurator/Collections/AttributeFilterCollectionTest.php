<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\Collections\AttributeFilterCollection;
use akmaljp\DriveMaru\Configurator\Items\AttributeFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Collections\AttributeFilterCollection
*/
class AttributeFilterCollectionTest extends Test
{
	/**
	* @testdox Filter names that start with # are normalized to lowercase
	*/
	public function testNormalizeKey()
	{
		$collection = new AttributeFilterCollection;
		$this->assertSame('#foo', $collection->normalizeKey('#FOO'));
	}

	/**
	* @testdox set() accepts instances of AttributeFilter as-is
	*/
	public function testValidValue()
	{
		$collection = new AttributeFilterCollection;
		$filter     = new AttributeFilter('mt_rand');

		$this->assertSame(
			$filter,
			$collection->set('#foo', $filter)
		);
	}

	/**
	* @testdox set() accepts a valid callback and returns an instance of AttributeFilter
	*/
	public function testValidCallback()
	{
		$collection = new AttributeFilterCollection;
		$filter     = $collection->set('#foo', 'strtolower');

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Items\\AttributeFilter',
			$filter
		);

		$this->assertSame('strtolower', $filter->getCallback());
	}

	/**
	* @testdox set() throws an exception if value is not a valid callback or an instance of AttributeFilter
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage must be a valid callback or an instance of akmaljp\DriveMaru\Configurator\Items\AttributeFilter
	*/
	public function testInvalidValue()
	{
		$collection = new AttributeFilterCollection;
		$collection->set('#foo', '#foo');
	}

	/**
	* @testdox get() automatically loads built-in filters if no filter was set
	*/
	public function testGetAutoload()
	{
		$collection = new AttributeFilterCollection;

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Items\\AttributeFilters\\NumberFilter',
			$collection->get('#number')
		);
	}

	/**
	* @testdox get() does not overwrite custom filters with built-in filters
	*/
	public function testGetNoOverwrite()
	{
		$collection = new AttributeFilterCollection;
		$collection->set('#number', new AttributeFilter(function(){}));

		$this->assertNotInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Items\\AttributeFilters\\NumberFilter',
			$collection->get('#number')
		);
	}

	/**
	* @testdox get() automatically creates filters whose name is a valid PHP callback if no filter was set
	*/
	public function testGetAutoloadCallback()
	{
		$collection = new AttributeFilterCollection;

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Items\\AttributeFilter',
			$collection->get('strtolower')
		);
	}

	/**
	* @testdox get() does not overwrite custom filters with auto-generated callback filters
	*/
	public function testGetNoOverwriteCallbacks()
	{
		$collection = new AttributeFilterCollection;
		$collection->set('strtolower', new AttributeFilter(function(){}));

		$this->assertNotSame(
			'strtolower',
			$collection->get('strtolower')->getCallback()
		);
	}

	/**
	* @testdox get() throws an exception if the filter name is neither callable not starts with # and is entirely composed of letters and digits
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Invalid filter name
	*/
	public function testInvalidKey()
	{
		$collection = new AttributeFilterCollection;
		$collection->get('../foo');
	}

	/**
	* @testdox get() throws an exception on unknown filter
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Unknown attribute filter
	*/
	public function testGetUnknown()
	{
		$collection = new AttributeFilterCollection;
		$collection->get('#foo');
	}

	/**
	* @testdox get() returns a clone of the filter, not the original instance
	*/
	public function testGetClone()
	{
		$collection = new AttributeFilterCollection;

		$this->assertEquals(
			$collection->get('#number'),
			$collection->get('#number')
		);

		$this->assertNotSame(
			$collection->get('#number'),
			$collection->get('#number')
		);
	}
}