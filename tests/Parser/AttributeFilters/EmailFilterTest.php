<?php

namespace akmaljp\DriveMaru\Tests\Parser\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\EmailFilter;

/**
* @covers akmaljp\DriveMaru\Parser\AttributeFilters\EmailFilter
*/
class EmailFilterTest extends AbstractFilterTest
{
	public function getFilterTests()
	{
		return [
			[new EmailFilter, 'example@example.com', 'example@example.com'],
			[new EmailFilter, 'example@example.com()', false],
		];
	}
}