<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\NumberFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\AttributeFilters\NumberFilter
*/
class NumberFilterTest extends Test
{
	/**
	* @testdox Callback is akmaljp\DriveMaru\Parser\AttributeFilters\RegexpFilter::filter()
	*/
	public function testCallback()
	{
		$filter = new NumberFilter;

		$this->assertSame(
			'akmaljp\\DriveMaru\\Parser\\AttributeFilters\\RegexpFilter::filter',
			$filter->getCallback()
		);
	}

	/**
	* @testdox Is safe in CSS
	*/
	public function testIsSafeInCSS()
	{
		$filter = new NumberFilter;
		$this->assertTrue($filter->isSafeInCSS());
	}

	/**
	* @testdox Is safe in JS
	*/
	public function testIsSafeInJS()
	{
		$filter = new NumberFilter;
		$this->assertTrue($filter->isSafeInJS());
	}

	/**
	* @testdox Is safe in URL
	*/
	public function testIsSafeInURL()
	{
		$filter = new NumberFilter;
		$this->assertTrue($filter->isSafeAsURL());
	}
}