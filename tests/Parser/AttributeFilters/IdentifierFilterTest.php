<?php

namespace akmaljp\DriveMaru\Tests\Parser\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\IdentifierFilter;

/**
* @covers akmaljp\DriveMaru\Parser\AttributeFilters\RegexpFilter
*/
class IdentifierFilterTest extends AbstractFilterTest
{
	public function getFilterTests()
	{
		return [
			[new IdentifierFilter, '123abcABC', '123abcABC'],
			[new IdentifierFilter, '-_-', '-_-'],
			[new IdentifierFilter, 'a b', false],
		];
	}
}