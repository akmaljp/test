<?php

namespace akmaljp\DriveMaru\Tests\Parser\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\TimestampFilter;

/**
* @covers akmaljp\DriveMaru\Parser\AttributeFilters\TimestampFilter
*/
class TimestampFilterTest extends AbstractFilterTest
{
	public function getFilterTests()
	{
		return [
			[new TimestampFilter, '123',      123],
			[new TimestampFilter, '12s',       12],
			[new TimestampFilter, '3m',       180],
			[new TimestampFilter, '2m10s',    130],
			[new TimestampFilter, '2h',      7200],
			[new TimestampFilter, '2h55s',   7255],
			[new TimestampFilter, '1h10m',   4200],
			[new TimestampFilter, '1h2m3s',  3723],
			[new TimestampFilter, '0h0m5s',     5],
			[new TimestampFilter, '1h0m0s',  3600],
			[new TimestampFilter, 'monday', false],
		];
	}
}