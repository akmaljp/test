<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\Collections\TemplateCheckList;
use akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowCopy;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Collections\TemplateCheckList
*/
class TemplateCheckListTest extends Test
{
	/**
	* @testdox append() normalizes a string into an instance of a class of the same name in akmaljp\DriveMaru\Configurator\TemplateChecks
	*/
	public function testAppendNormalizeValue()
	{
		$collection = new TemplateCheckList;

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\TemplateChecks\\DisallowCopy',
			$collection->append('DisallowCopy')
		);
	}

	/**
	* @testdox append() adds instances of akmaljp\DriveMaru\Configurator\TemplateCheck as-is
	*/
	public function testAppendInstance()
	{
		$collection = new TemplateCheckList;
		$check      = new DisallowCopy;

		$this->assertSame(
			$check,
			$collection->append($check)
		);
	}
}