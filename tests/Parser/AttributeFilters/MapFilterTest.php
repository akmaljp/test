<?php

namespace akmaljp\DriveMaru\Tests\Parser\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\MapFilter;

/**
* @covers akmaljp\DriveMaru\Parser\AttributeFilters\MapFilter
*/
class MapFilterTest extends AbstractFilterTest
{
	public function getFilterTests()
	{
		return [
			[new MapFilter(['uno' => 'one', 'dos' => 'two']), 'dos', 'two'],
			[new MapFilter(['uno' => 'one', 'dos' => 'two']), 'three', 'three'],
			[new MapFilter(['uno' => 'one', 'dos' => 'two'], true, true), 'three', false],
		];
	}
}