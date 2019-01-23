<?php

namespace akmaljp\DriveMaru\Tests\Parser\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\RangeFilter;

/**
* @covers akmaljp\DriveMaru\Parser\AttributeFilters\NumericFilter
*/
class RangeFilterTest extends AbstractFilterTest
{
	public function getFilterTests()
	{
		return [
			[new RangeFilter(2, 5), '2', 2],
			[new RangeFilter(2, 5), '5', 5],
			[new RangeFilter(-5, 5), '-5', -5],
			[
				new RangeFilter(2, 5),
				'1',
				2,
				[
					[
						'warn',
						'Value outside of range, adjusted up to min value',
						['attrValue' => 1, 'min' => 2, 'max' => 5]
					]
				]
			],
			[
				new RangeFilter(2, 5),
				'10',
				5,
				[
					[
						'warn',
						'Value outside of range, adjusted down to max value',
						['attrValue' => 10, 'min' => 2, 'max' => 5]
					]
				]
			],
			[new RangeFilter(2, 5), '5x', false],
		];
	}
}