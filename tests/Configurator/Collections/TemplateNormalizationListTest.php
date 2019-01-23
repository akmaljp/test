<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\Collections\TemplateNormalizationList;
use akmaljp\DriveMaru\Configurator\TemplateNormalizations\Custom;
use akmaljp\DriveMaru\Configurator\TemplateNormalizations\RemoveComments;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Collections\TemplateNormalizationList
*/
class TemplateNormalizationListTest extends Test
{
	/**
	* @testdox append() normalizes a callback into an instance of akmaljp\DriveMaru\Configurator\TemplateNormalizations\Custom
	*/
	public function testAppendCallback()
	{
		$callback   = function () {};
		$collection = new TemplateNormalizationList;

		$this->assertEquals(
			new Custom($callback),
			$collection->append($callback)
		);
	}

	/**
	* @testdox append() normalizes a string into an instance of a class of the same name in akmaljp\DriveMaru\Configurator\TemplateNormalizations
	*/
	public function testAppendString()
	{
		$collection = new TemplateNormalizationList;

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\TemplateNormalizations\\RemoveComments',
			$collection->append('RemoveComments')
		);
	}

	/**
	* @testdox append() adds instances of akmaljp\DriveMaru\Configurator\TemplateNormalization as-is
	*/
	public function testAppendInstance()
	{
		$collection = new TemplateNormalizationList;
		$instance   = new RemoveComments;

		$this->assertSame(
			$instance,
			$collection->append($instance)
		);
	}
}