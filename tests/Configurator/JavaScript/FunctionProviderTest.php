<?php

namespace akmaljp\DriveMaru\Tests\Configurator\JavaScript;

use akmaljp\DriveMaru\Configurator\JavaScript\FunctionProvider;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\JavaScript\FunctionProvider
*/
class FunctionProviderTest extends Test
{
	public function tearDown()
	{
		unset(FunctionProvider::$cache['foo']);
	}

	/**
	* @testdox get() will return the source from cache if available
	*/
	public function testReturnFromCache()
	{
		FunctionProvider::$cache['foo'] = 'alert(1)';
		$this->assertSame('alert(1)', FunctionProvider::get('foo'));
	}

	/**
	* @testdox get() will return the source from the filesystem if applicable
	*/
	public function testReturnFromFilesystem()
	{
		unset(FunctionProvider::$cache['foo']);
		$filepath = __DIR__ . '/../../../src/Configurator/JavaScript/functions/foo.js';
		self::$tmpFiles[] = $filepath;
		file_put_contents($filepath, 'alert(2)');
		$this->assertSame('alert(2)', FunctionProvider::get('foo'));
	}

	/**
	* @testdox get() will throw an exception if the function can't be sourced
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Unknown function 'foobar'
	*/
	public function testInvalid()
	{
		unset(FunctionProvider::$cache['foobar']);
		FunctionProvider::get('foobar');
	}
}