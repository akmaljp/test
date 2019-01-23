<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items;

use akmaljp\DriveMaru\Configurator\Items\TagFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\TagFilter
*/
class TagFilterTest extends Test
{
	/**
	* @testdox Sets the filter's signature to ['tag' => null]
	*/
	public function testDefaultSignature()
	{
		$filter = new TagFilter(function($v){});
		$config = $filter->asConfig();

		$this->assertSame(
			['tag' => null],
			$config['params']
		);
	}
}