<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\Collections\HostnameList;
use akmaljp\DriveMaru\Configurator\Helpers\ConfigHelper;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Collections\HostnameList
*/
class HostnameListTest extends Test
{
	/**
	* @testdox asConfig() returns null if the collection is empty
	*/
	public function testAsConfigNull()
	{
		$list = new HostnameList;

		$this->assertNull($list->asConfig());
	}

	/**
	* @testdox asConfig() returns a Regexp
	*/
	public function testAsConfigRegexp()
	{
		$list = new HostnameList;
		$list->add('example.org');

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Items\\Regexp',
			$list->asConfig()
		);
	}

	/**
	* @testdox asConfig() returns a regexp that matches its hostnames
	*/
	public function testAsConfigRegexpMatch()
	{
		$list = new HostnameList;
		$list->add('example.org');

		$this->assertRegexp(
			(string) $list->asConfig(),
			'example.org'
		);
	}

	/**
	* @requires function idn_to_ascii
	* @testdox IDNs are punycoded if idn_to_ascii() is available
	*/
	public function testIDNsArePunycoded()
	{
		$list = new HostnameList;
		$list->add('pаypal.com');

		$this->assertContains(
			'xn--pypal-4ve\\.com',
			(string) $list->asConfig()
		);
	}

	/**
	* @testdox add('*.example.org') matches 'www.example.org'
	*/
	public function testWildcardStart()
	{
		$list = new HostnameList;
		$list->add('*.example.org');

		$this->assertRegexp(
			(string) $list->asConfig(),
			'www.example.org'
		);
	}

	/**
	* @testdox add('example.org') does not match 'www.example.org'
	*/
	public function testNoWildcardStart()
	{
		$list = new HostnameList;
		$list->add('example.org');

		$this->assertNotRegexp(
			(string) $list->asConfig(),
			'www.example.org'
		);
	}

	/**
	* @testdox add('example.*') matches 'example.org'
	*/
	public function testWildcardEnd()
	{
		$list = new HostnameList;
		$list->add('example.*');

		$this->assertRegexp(
			(string) $list->asConfig(),
			'example.org'
		);
	}

	/**
	* @testdox add('example') does not match 'example.org'
	*/
	public function testNoWildcardEnd()
	{
		$list = new HostnameList;
		$list->add('example');

		$this->assertNotRegexp(
			(string) $list->asConfig(),
			'example.org'
		);
	}
}