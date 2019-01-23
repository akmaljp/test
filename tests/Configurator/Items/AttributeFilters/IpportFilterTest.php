<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\IpportFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\AttributeFilters\IpportFilter
*/
class IpportFilterTest extends Test
{
	/**
	* @testdox Callback is akmaljp\DriveMaru\Parser\AttributeFilters\NetworkFilter::filterIpport()
	*/
	public function testCallback()
	{
		$filter = new IpportFilter;

		$this->assertSame(
			'akmaljp\\DriveMaru\\Parser\\AttributeFilters\\NetworkFilter::filterIpport',
			$filter->getCallback()
		);
	}
}