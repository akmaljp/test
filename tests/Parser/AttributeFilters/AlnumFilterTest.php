<?php

namespace akmaljp\DriveMaru\Tests\Parser\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\AlnumFilter;

/**
* @covers akmaljp\DriveMaru\Parser\AttributeFilters\RegexpFilter
*/
class AlnumFilterTest extends AbstractFilterTest
{
	public function getFilterTests()
	{
		return [
			[new AlnumFilter, '', false],
			[new AlnumFilter, 'abcDEF', 'abcDEF'],
			[new AlnumFilter, 'abc_def', false],
			[new AlnumFilter, '0123', '0123'],
			[new AlnumFilter, 'é', false],
		];
	}
}