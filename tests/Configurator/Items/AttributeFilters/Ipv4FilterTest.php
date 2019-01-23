<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\Ipv4Filter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\AttributeFilters\Ipv4Filter
*/
class Ipv4FilterTest extends Test
{
	/**
	* @testdox Callback is akmaljp\DriveMaru\Parser\AttributeFilters\NetworkFilter::filterIpv4()
	*/
	public function testCallback()
	{
		$filter = new Ipv4Filter;

		$this->assertSame(
			'akmaljp\\DriveMaru\\Parser\\AttributeFilters\\NetworkFilter::filterIpv4',
			$filter->getCallback()
		);
	}
}