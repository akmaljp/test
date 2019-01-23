<?php

namespace akmaljp\DriveMaru\Tests\Parser\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\RegexpFilter;

/**
* @covers akmaljp\DriveMaru\Parser\AttributeFilters\RegexpFilter
*/
class RegexpFilterTest extends AbstractFilterTest
{
	public function getFilterTests()
	{
		return [
			[new RegexpFilter('/^[A-Z]+$/D'), 'ABC', 'ABC'],
			[new RegexpFilter('/^[A-Z]+$/D'), 'Abc', false],
		];
	}
}