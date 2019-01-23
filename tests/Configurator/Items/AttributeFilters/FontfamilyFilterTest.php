<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Helpers\ConfigHelper;
use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\FontfamilyFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\AttributeFilters\FontfamilyFilter
*/
class FontfamilyTest extends Test
{
	/**
	* @testdox Is safe as URL
	*/
	public function testURLSafe()
	{
		$filter = new FontfamilyFilter;

		$this->assertTrue($filter->isSafeAsURL());
	}

	/**
	* @testdox Is safe in CSS
	*/
	public function testCSSSafe()
	{
		$filter = new FontfamilyFilter;

		$this->assertTrue($filter->isSafeInCSS());
	}

	/**
	* @testdox Is not safe in JS
	*/
	public function testJSUnsafe()
	{
		$filter = new FontfamilyFilter;

		$this->assertFalse($filter->isSafeInJS());
	}
}