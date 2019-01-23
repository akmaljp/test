<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\Collections\AttributeFilterChain;
use akmaljp\DriveMaru\Configurator\Items\AttributeFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Collections\FilterChain
* @covers akmaljp\DriveMaru\Configurator\Collections\AttributeFilterChain
*/
class AttributeFilterChainTest extends Test
{
	private function privateMethod() {}
	public function doNothing() {}

	/**
	* @testdox append() throws an InvalidArgumentException on invalid callbacks
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Filter '*invalid*' is neither callable nor an instance of akmaljp\DriveMaru\Configurator\Items\AttributeFilter
	*/
	public function testAppendInvalidCallback()
	{
		$filterChain = new AttributeFilterChain;
		$filterChain->append('*invalid*');
	}

	/**
	* @testdox prepend() throws an InvalidArgumentException on invalid callbacks
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Filter '*invalid*' is neither callable nor an instance of akmaljp\DriveMaru\Configurator\Items\AttributeFilter
	*/
	public function testPrependInvalidCallback()
	{
		$filterChain = new AttributeFilterChain;
		$filterChain->prepend('*invalid*');
	}

	/**
	* @testdox append() throws an InvalidArgumentException on uncallable callbacks
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage is neither callable nor an instance of akmaljp\DriveMaru\Configurator\Items\AttributeFilter
	*/
	public function testAppendUncallableCallback()
	{
		$filterChain = new AttributeFilterChain;
		$filterChain->append([__CLASS__, 'privateMethod']);
	}

	/**
	* @testdox prepend() throws an InvalidArgumentException on uncallable callbacks
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage is neither callable nor an instance of akmaljp\DriveMaru\Configurator\Items\AttributeFilter
	*/
	public function testPrependUncallableCallback()
	{
		$filterChain = new AttributeFilterChain;
		$filterChain->prepend([__CLASS__, 'privateMethod']);
	}

	/**
	* @testdox PHP string callbacks are normalized to an instance of AttributeFilter
	*/
	public function testStringCallback()
	{
		$filterChain = new AttributeFilterChain;

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Items\\AttributeFilter',
			$filterChain->append('strtolower')
		);
	}

	/**
	* @testdox PHP array callbacks are normalized to an instance of AttributeFilter
	*/
	public function testArrayCallback()
	{
		$filterChain = new AttributeFilterChain;

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Items\\AttributeFilter',
			$filterChain->append([$this, 'doNothing'])
		);
	}

	/**
	* @testdox Default filters such as "#int" are normalized to an instance of the corresponding AttributeFilter
	*/
	public function testDefaultFilter()
	{
		$filterChain = new AttributeFilterChain;

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Items\\AttributeFilters\\IntFilter',
			$filterChain->append('#int')
		);
	}

	/**
	* @testdox Instances of AttributeFilter are added as-is
	*/
	public function testAttributeFilterInstance()
	{
		$filterChain = new AttributeFilterChain;
		$filter = new AttributeFilter('strtolower');

		$this->assertSame(
			$filter,
			$filterChain->append($filter)
		);
	}
}