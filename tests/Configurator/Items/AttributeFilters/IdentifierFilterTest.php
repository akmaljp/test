<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\IdentifierFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\AttributeFilters\IdentifierFilter
*/
class IdentifierFilterTest extends Test
{
	/**
	* @testdox Callback is akmaljp\DriveMaru\Parser\AttributeFilters\RegexpFilter::filter()
	*/
	public function testCallback()
	{
		$filter = new IdentifierFilter;

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
		$filter = new IdentifierFilter;
		$this->assertTrue($filter->isSafeInCSS());
	}

	/**
	* @testdox Is safe in URL
	*/
	public function testIsSafeInURL()
	{
		$filter = new IdentifierFilter;
		$this->assertTrue($filter->isSafeAsURL());
	}
}