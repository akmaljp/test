<?php

namespace akmaljp\DriveMaru\Tests\Configurator\JavaScript\Minifiers;

use akmaljp\DriveMaru\Configurator\JavaScript\Minifiers\MatthiasMullieMinify;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\JavaScript\Minifiers\MatthiasMullieMinify
*/
class MatthiasMullieMinifyTest extends Test
{
	public function setUp()
	{
		if (!class_exists('MatthiasMullie\\Minify\\JS'))
		{
			$this->markTestSkipped('Requires MatthiasMullie\\Minify\\JS');
		}
	}

	/**
	* @testdox minify() works
	*/
	public function testWorks()
	{
		$minifier = new MatthiasMullieMinify;
		$this->assertSame('alert(1)', $minifier->minify('alert(1);'));
	}
}