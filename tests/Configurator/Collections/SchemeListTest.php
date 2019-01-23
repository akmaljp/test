<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\Collections\SchemeList;
use akmaljp\DriveMaru\Configurator\Helpers\ConfigHelper;
use akmaljp\DriveMaru\Configurator\JavaScript\Code;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Collections\SchemeList
*/
class SchemeListTest extends Test
{
	/**
	* @testdox asConfig() returns an instance of Regexp
	*/
	public function testAsConfigRegexp()
	{
		$list = new SchemeList;
		$list->add('http');

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Items\\Regexp',
			$list->asConfig()
		);
	}

	/**
	* @testdox asConfig() returns a regexp that matches all the allowed schemes in the default variant
	*/
	public function testAsConfigRegexpDefault()
	{
		$list = new SchemeList;
		$list->add('http');
		$list->add('https');

		$this->assertEquals('/^https?$/Di', $list->asConfig());
	}

	/**
	* @testdox asConfig() creates a case-insensitive regexp that matches the schemes in the collection
	*/
	public function testAsConfigRegexpMatch()
	{
		$list = new SchemeList;
		$list->add('http');
		$list->add('https');
		$list->add('ftp');

		$regexp = (string) $list->asConfig();

		$this->assertRegexp($regexp,    'http');
		$this->assertRegexp($regexp,    'https');
		$this->assertRegexp($regexp,    'ftp');
		$this->assertRegexp($regexp,    'FTP');
		$this->assertNotRegexp($regexp, 'ftps');
	}

	/**
	* @testdox add('*invalid*') throws an exception
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Invalid scheme name '*invalid*'
	*/
	public function testInvalid()
	{
		$list = new SchemeList;
		$list->add('*invalid*');
	}

	/**
	* @testdox add() normalizes schemes to lowercase
	*/
	public function testLowercase()
	{
		$list = new SchemeList;
		$list->add('HTTP');

		$this->assertSame(['http'], iterator_to_array($list));
	}
}