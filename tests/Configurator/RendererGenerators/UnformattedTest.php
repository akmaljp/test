<?php

namespace akmaljp\DriveMaru\Tests\Configurator\RendererGenerators;

use akmaljp\DriveMaru\Configurator\RendererGenerators\Unformatted;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\RendererGenerators\Unformatted
*/
class UnformattedTest extends Test
{
	/**
	* @testdox Returns an instance of Renderer
	*/
	public function testInstance()
	{
		$generator = new Unformatted;
		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Renderer',
			$generator->getRenderer($this->configurator->rendering)
		);
	}
}