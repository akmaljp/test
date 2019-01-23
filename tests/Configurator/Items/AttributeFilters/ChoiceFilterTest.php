<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\ChoiceFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\AttributeFilters\ChoiceFilter
*/
class ChoiceFilterTest extends Test
{
	/**
	* @testdox Callback is akmaljp\DriveMaru\Parser\AttributeFilters\RegexpFilter::filter()
	*/
	public function testCallback()
	{
		$filter = new ChoiceFilter;

		$this->assertSame(
			'akmaljp\\DriveMaru\\Parser\\AttributeFilters\\RegexpFilter::filter',
			$filter->getCallback()
		);
	}

	/**
	* @testdox __construct() forwards its arguments to setValues()
	*/
	public function testConstructorArguments()
	{
		$className = 'akmaljp\\DriveMaru\\Configurator\\Items\\AttributeFilters\\ChoiceFilter';
		$filter = $this->getMockBuilder($className)
		               ->disableOriginalConstructor()
		               ->getMock();

		$filter->expects($this->once())
		       ->method('setValues')
		       ->with(['one', 'two'], true);

		$filter->__construct(['one', 'two'], true);
	}

	/**
	* @testdox setValues() creates a regexp that matches all given values (case-insensitive) and calls setRegexp()
	*/
	public function testSetValues()
	{
		$filter = $this->getMockBuilder('akmaljp\\DriveMaru\\Configurator\\Items\\AttributeFilters\\ChoiceFilter')
		             ->setMethods(['setRegexp'])
		             ->getMock();

		$filter->expects($this->once())
		       ->method('setRegexp')
		       ->with('/^(?>one|two)$/Di');

		$filter->setValues(['one', 'two']);
	}

	/**
	* @testdox setValues() creates a case-sensitive regexp if its second argument is TRUE
	*/
	public function testSetValuesCaseSensitive()
	{
		$filter = $this->getMockBuilder('akmaljp\\DriveMaru\\Configurator\\Items\\AttributeFilters\\ChoiceFilter')
		             ->setMethods(['setRegexp'])
		             ->getMock();

		$filter->expects($this->once())
		       ->method('setRegexp')
		       ->with('/^(?>one|two)$/D');

		$filter->setValues(['one', 'two'], true);
	}

	/**
	* @testdox setValues() creates a Unicode-aware regexp if any values are non-ASCII
	*/
	public function testSetValuesUnicode()
	{
		$filter = $this->getMockBuilder('akmaljp\\DriveMaru\\Configurator\\Items\\AttributeFilters\\ChoiceFilter')
		             ->setMethods(['setRegexp'])
		             ->getMock();

		$filter->expects($this->once())
		       ->method('setRegexp')
		       ->with('/^(?>pokémon|yugioh)$/Diu');

		$filter->setValues(['pokémon', 'yugioh']);
	}

	/**
	* @testdox setValues() throws an exception if its second argument is not a boolean
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage must be a boolean
	*/
	public function testSetValuesInvalidBool()
	{
		$filter = new ChoiceFilter;
		$filter->setValues(['one', 'two'], 'notabool');
	}
}