<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\IpFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\AttributeFilters\IpFilter
*/
class IpFilterTest extends Test
{
	/**
	* @testdox Callback is akmaljp\DriveMaru\Parser\AttributeFilters\NetworkFilter::filterIp()
	*/
	public function testCallback()
	{
		$filter = new IpFilter;

		$this->assertSame(
			'akmaljp\\DriveMaru\\Parser\\AttributeFilters\\NetworkFilter::filterIp',
			$filter->getCallback()
		);
	}
}