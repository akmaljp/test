<?php

namespace akmaljp\DriveMaru\Tests\Parser\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\HashmapFilter;

/**
* @covers akmaljp\DriveMaru\Parser\AttributeFilters\HashmapFilter
*/
class HashmapFilterTest extends AbstractFilterTest
{
	public function getFilterTests()
	{
		return [
			[new HashmapFilter(['foo' => 'bar']), 'foo', 'bar'],
			[new HashmapFilter(['foo' => 'bar']), 'bar', 'bar'],
			[new HashmapFilter(['foo' => 'bar'], false), 'bar', 'bar'],
			[new HashmapFilter(['foo' => 'bar'], true), 'bar', false],
		];
	}
}