<?php

namespace akmaljp\DriveMaru\Tests\Configurator\JavaScript\Minifiers;

use akmaljp\DriveMaru\Configurator\JavaScript\Minifiers\Noop;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\JavaScript\Minifiers\Noop
*/
class NoopTest extends Test
{
	/**
	* @testdox minify() returns its first argument
	*/
	public function testNoop()
	{
		$original =
			"function hello(name) {
				alert('Hello, ' + name);
			}
			hello('New user')";

		$expected = $original;

		$minifier = new Noop;
		$this->assertSame($expected, $minifier->minify($original));
	}

	/**
	* @testdox getCacheDifferentiator() is constant
	*/
	public function testGetCacheDifferentiator()
	{
		$minifier = new Noop;
		$this->assertSame(
			$minifier->getCacheDifferentiator(),
			$minifier->getCacheDifferentiator()
		);
	}
}