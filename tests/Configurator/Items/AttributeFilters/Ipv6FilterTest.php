<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\Ipv6Filter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\AttributeFilters\Ipv6Filter
*/
class Ipv6FilterTest extends Test
{
	/**
	* @testdox Callback is akmaljp\DriveMaru\Parser\AttributeFilters\NetworkFilter::filterIpv6()
	*/
	public function testCallback()
	{
		$filter = new Ipv6Filter;

		$this->assertSame(
			'akmaljp\\DriveMaru\\Parser\\AttributeFilters\\NetworkFilter::filterIpv6',
			$filter->getCallback()
		);
	}
}