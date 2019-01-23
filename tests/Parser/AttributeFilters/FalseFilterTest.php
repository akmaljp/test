<?php

namespace akmaljp\DriveMaru\Tests\Parser\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\FalseFilter;

/**
* @covers akmaljp\DriveMaru\Parser\AttributeFilters\FalseFilter
*/
class FalseFilterTest extends AbstractFilterTest
{
	public function getFilterTests()
	{
		return [
			[new FalseFilter, 'bar', false],
			[new FalseFilter, 'false', false],
		];
	}
}