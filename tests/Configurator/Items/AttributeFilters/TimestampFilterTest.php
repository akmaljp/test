<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\TimestampFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\AttributeFilters\TimestampFilter
*/
class TimestampFilterTest extends Test
{
	/**
	* @testdox Callback is akmaljp\DriveMaru\Parser\AttributeFilters\RegexpFilter::filter()
	*/
	public function testCallback()
	{
		$filter = new TimestampFilter;

		$this->assertSame(
			'akmaljp\\DriveMaru\\Parser\\AttributeFilters\\TimestampFilter::filter',
			$filter->getCallback()
		);
	}

	/**
	* @testdox Is safe in CSS
	*/
	public function testIsSafeInCSS()
	{
		$filter = new TimestampFilter;
		$this->assertTrue($filter->isSafeInCSS());
	}

	/**
	* @testdox Is safe in JS
	*/
	public function testIsSafeInJS()
	{
		$filter = new TimestampFilter;
		$this->assertTrue($filter->isSafeInJS());
	}

	/**
	* @testdox Is safe in URL
	*/
	public function testIsSafeInURL()
	{
		$filter = new TimestampFilter;
		$this->assertTrue($filter->isSafeAsURL());
	}
}