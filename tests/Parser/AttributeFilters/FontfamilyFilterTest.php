<?php

namespace akmaljp\DriveMaru\Tests\Parser\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\FontfamilyFilter;

/**
* @covers akmaljp\DriveMaru\Parser\AttributeFilters\RegexpFilter
*/
class FontfamilyFilterTest extends AbstractFilterTest
{
	public function getFilterTests()
	{
		return [
			[new FontfamilyFilter, 'Arial', 'Arial'],
			[new FontfamilyFilter, '"Arial"', '"Arial"'],
			[new FontfamilyFilter, '"Arial""Arial"', false],
			[new FontfamilyFilter, 'Arial,serif', 'Arial,serif'],
			[new FontfamilyFilter, 'Arial, serif, sans-serif', 'Arial, serif, sans-serif'],
			[new FontfamilyFilter, 'Arial, Times New Roman', 'Arial, Times New Roman'],
			[new FontfamilyFilter, 'Arial, "Times New Roman"', 'Arial, "Times New Roman"'],
			[new FontfamilyFilter, "Arial, 'Times New Roman'", "Arial, 'Times New Roman'"],
			[new FontfamilyFilter, 'url(whatever)', false],
		];
	}
}