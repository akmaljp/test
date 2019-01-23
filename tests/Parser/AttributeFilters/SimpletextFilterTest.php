<?php

namespace akmaljp\DriveMaru\Tests\Parser\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\SimpletextFilter;

/**
* @covers akmaljp\DriveMaru\Parser\AttributeFilters\RegexpFilter
*/
class SimpletextFilterTest extends AbstractFilterTest
{
	public function getFilterTests()
	{
		return [
			[
				new SimpletextFilter,
				'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-+.,_ ', 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-+.,_ '
			],
			[new SimpletextFilter, 'a()b', false],
			[new SimpletextFilter, 'a[]b', false],
		];
	}
}