<?php

namespace akmaljp\DriveMaru\Tests\Configurator;

use akmaljp\DriveMaru\Configurator\Items\Regexp;
use akmaljp\DriveMaru\Configurator\JavaScript\Code;
use akmaljp\DriveMaru\Configurator\JavaScript\ConfigValue;
use akmaljp\DriveMaru\Configurator\JavaScript\Dictionary;
use akmaljp\DriveMaru\Configurator\JavaScript\Encoder;
use akmaljp\DriveMaru\Tests\Test;

/**
* @requires extension json
* @covers akmaljp\DriveMaru\Configurator\JavaScript\Encoder
*/
class EncoderTest extends Test
{
	/**
	* @testdox encode() tests
	* @dataProvider getEncodeTests
	*/
	public function testEncode($original, $expected)
	{
		$encoder = new Encoder;
		$this->assertSame($expected, $encoder->encode($original));
	}

	public function getEncodeTests()
	{
		return [
			[
				123,
				'123'
			],
			[
				'foo',
				'"foo"'
			],
			[
				false,
				'!1'
			],
			[
				true,
				'!0'
			],
			[
				[],
				'[]'
			],
			[
				[1, 2],
				'[1,2]'
			],
			[
				[1 => 1, 0 => 0],
				'{"0":0,"1":1}'
			],
			[
				[false, 2],
				'[!1,2]'
			],
			[
				['foo' => 'bar', 'baz' => 'quux'],
				'{baz:"quux",foo:"bar"}'
			],
			[
				['' => 'bar', 'baz' => 'quux'],
				'{"":"bar",baz:"quux"}'
			],
			[
				new Dictionary(['foo' => 'bar', 'baz' => 'quux']),
				'{"baz":"quux","foo":"bar"}'
			],
			[
				new Dictionary(['' => 'bar', 'baz' => 'quux']),
				'{"":"bar","baz":"quux"}'
			],
			[
				new Regexp('#^foo$#'),
				'/^foo$/'
			],
			[
				new Code('function(){return false;}'),
				'function(){return false;}'
			],
			[
				new Dictionary(['foo' => "bar\r\n"]),
				'{"foo":"bar\\r\\n"}'
			],
			[
				new Dictionary(["foo\r\n" => 'bar']),
				'{"foo\\r\\n":"bar"}'
			],
			[
				new Dictionary(['foo' => "bar\xE2\x80\xA8"]),
				'{"foo":"bar\\u2028"}'
			],
			[
				new Dictionary(['foo' => "bar\xE2\x80\xA9"]),
				'{"foo":"bar\\u2029"}'
			],
			[
				new ConfigValue([0, 0], 'o82015558'),
				'[0,0]'
			],
		];
	}

	/**
	* @testdox encode() does not quote legal property names
	*/
	public function testLegalProps()
	{
		$legal = [
			'foo',
			'foo33',
			'G89',
			'$foo',
			'$foo$bar',
			'foo_bar'
		];

		$encoder = new Encoder;
		$js = $encoder->encode(array_flip($legal));
		foreach ($legal as $name)
		{
			$this->assertContains($name . ':', $js);
		}
	}

	/**
	* @testdox encode() quotes illegal property names
	*/
	public function testIllegalProps()
	{
		$illegal = [
			'',
			'0foo',
			'foo bar',
			"foo\n",
			'foo-bar',
			"'foo'",
			'"foo"',
			'youtube.com',
			'with',
			'break',
			'false',
			'float'
		];

		$encoder = new Encoder;
		$js = $encoder->encode(array_flip($illegal));
		foreach ($illegal as $name)
		{
			$this->assertContains(json_encode($name) . ':', $js);
		}
	}

	/**
	* @testdox encode() throws an exception on unsupported types
	* @expectedException RuntimeException
	* @expectedExceptionMessage Cannot encode resource value
	*/
	public function testEncodeUnsupportedType()
	{
		$encoder = new Encoder;
		$encoder->encode(fopen('php://stdin', 'rb'));
	}

	/**
	* @testdox encode() throws an exception on unsupported objects
	* @expectedException RuntimeException
	* @expectedExceptionMessage Cannot encode instance of Closure
	*/
	public function testEncodeUnsupportedObjects()
	{
		$encoder = new Encoder;
		$encoder->encode(function(){});
	}

	/**
	* @testdox encode() properly encodes deduplicated config values
	*/
	public function testEncodeDeduplicatedConfigValue()
	{
		$configValue = new ConfigValue([0, 0], 'o82015558');
		$configValue->incrementUseCount();
		$configValue->incrementUseCount();
		$configValue->deduplicate();

		$encoder = new Encoder;
		$this->assertSame('o82015558', $encoder->encode($configValue));
	}
}