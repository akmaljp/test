<?php

namespace akmaljp\DriveMaru\Tests\Configurator\JavaScript;

use akmaljp\DriveMaru\Configurator\JavaScript\Code;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\JavaScript\Code
*/
class CodeTest extends Test
{
	/**
	* @testdox Can be cast as a string
	*/
	public function testAsString()
	{
		$js   = 'alert("ok")';
		$code = new Code($js);

		$this->assertSame($js, (string) $code);
	}

	/**
	* @testdox __toString() always returns a string
	*/
	public function testAsStringType()
	{
		$this->assertSame(
			'42',
			(string) new Code(42)
		);
	}

	/**
	* @testdox filterConfig('PHP') returns null
	*/
	public function testFilterConfigPHP()
	{
		$js   = 'alert("ok")';
		$code = new Code($js);

		$this->assertNull($code->filterConfig('PHP'));
	}

	/**
	* @testdox filterConfig('PHP') returns the Code instance
	*/
	public function testFilterConfigJS()
	{
		$js   = 'alert("ok")';
		$code = new Code($js);

		$this->assertSame($code, $code->filterConfig('JS'));
	}
}