<?php

namespace akmaljp\DriveMaru\Tests\Configurator;

use akmaljp\DriveMaru\Configurator\JavaScript\Dictionary;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\JavaScript\Dictionary
*/
class DictionaryTest extends Test
{
	/**
	* @testdox filterConfig('PHP') returns an array
	*/
	public function testFilterConfigPHP()
	{
		$dict = new Dictionary(['foo' => 1, 'bar' => 2]);
		$this->assertSame(
			['foo' => 1, 'bar' => 2],
			$dict->filterConfig('PHP')
		);
	}

	/**
	* @testdox filterConfig('JS') returns an equal but different instance of Dictionary
	*/
	public function testFilterConfigJS()
	{
		$original = new Dictionary(['foo' => 1, 'bar' => 2]);
		$actual   = $original->filterConfig('JS');

		$this->assertEquals($original, $actual);
		$this->assertNotSame($original, $actual);
	}

	/**
	* @testdox filterConfig('JS') filters the dictionary's content
	*/
	public function testFilterConfigRecursive()
	{
		$mock = $this->getMockBuilder('akmaljp\\DriveMaru\\Configurator\\FilterableConfigValue')->getMock();
		$mock->expects($this->once())
		     ->method('filterConfig')
		     ->with('JS')
		     ->will($this->returnValue(42));

		$original = new Dictionary(['foo' => ['bar' => $mock]]);
		$expected = new Dictionary(['foo' => ['bar' => 42]]);
		$actual   = $original->filterConfig('JS');

		$this->assertEquals($expected, $actual);
	}
}