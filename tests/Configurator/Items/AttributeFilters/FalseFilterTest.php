<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\FalseFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\AttributeFilters\FalseFilter
*/
class FalseFilterTest extends Test
{
	/**
	* @testdox Callback is akmaljp\DriveMaru\Parser\AttributeFilters\FalseFilter::filter()
	*/
	public function testCallback()
	{
		$filter = new FalseFilter;

		$this->assertSame(
			'akmaljp\\DriveMaru\\Parser\\AttributeFilters\\FalseFilter::filter',
			$filter->getCallback()
		);
	}
}