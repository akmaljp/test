<?php

namespace akmaljp\DriveMaru\Tests\Configurator;

use akmaljp\DriveMaru\Configurator\JavaScript\Code;
use akmaljp\DriveMaru\Configurator\JavaScript\StylesheetCompressor;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\JavaScript\StylesheetCompressor
*/
class StylesheetCompressorTest extends Test
{
	/**
	* @testdox encode() tests
	* @dataProvider getEncodeTests
	*/
	public function testEncode($original, $expected)
	{
		$stylesheetCompressor = new StylesheetCompressor;
		$this->assertSame($expected, $stylesheetCompressor->encode($original));
	}

	public function getEncodeTests()
	{
		$tests = [];
		$dir   = __DIR__ . '/data/StylesheetCompressor/';
		foreach (glob($dir . '*.xsl') as $filepath)
		{
			$tests[] = [file_get_contents($filepath), file_get_contents(substr($filepath, 0, -3) . 'js')];
		}

		return $tests;
	}
}