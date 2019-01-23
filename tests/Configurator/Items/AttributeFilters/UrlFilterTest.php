<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\UrlFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\AttributeFilters\UrlFilter
*/
class UrlFilterTest extends Test
{
	/**
	* @testdox Callback is akmaljp\DriveMaru\Parser\AttributeFilters\UrlFilter::filter()
	*/
	public function testCallback()
	{
		$filter = new UrlFilter;

		$this->assertSame(
			'akmaljp\\DriveMaru\\Parser\\AttributeFilters\\UrlFilter::filter',
			$filter->getCallback()
		);
	}

	/**
	* @testdox Is safe in CSS
	*/
	public function testIsSafeInCSS()
	{
		$filter = new UrlFilter;
		$this->assertTrue($filter->isSafeInCSS());
	}

	/**
	* @testdox Is safe in JS
	*/
	public function testIsSafeInJS()
	{
		$filter = new UrlFilter;
		$this->assertTrue($filter->isSafeInJS());
	}

	/**
	* @testdox Is safe in URL
	*/
	public function testIsSafeInURL()
	{
		$filter = new UrlFilter;
		$this->assertTrue($filter->isSafeAsURL());
	}
}