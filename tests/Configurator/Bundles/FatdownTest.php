<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Bundles;

use akmaljp\DriveMaru\Configurator\Bundles\Fatdown;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Bundles\Fatdown
*/
class FatdownTest extends Test
{
	/**
	* @testdox Features
	*/
	public function testFeatures()
	{
		$configurator = Fatdown::getConfigurator();

		$this->assertTrue(isset($configurator->Autoemail));
		$this->assertTrue(isset($configurator->Autolink));
		$this->assertTrue(isset($configurator->Escaper));
		$this->assertTrue(isset($configurator->FancyPants));
		$this->assertTrue(isset($configurator->HTMLComments));
		$this->assertTrue(isset($configurator->HTMLElements));
		$this->assertTrue(isset($configurator->HTMLEntities));
		$this->assertTrue(isset($configurator->Litedown));
		$this->assertTrue(isset($configurator->MediaEmbed));
	}
}