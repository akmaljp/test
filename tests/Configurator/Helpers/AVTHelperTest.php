<?php

namespace s9e\TextFormatter\Tests\Configurator\Helpers;

use DOMDocument;
use Exception;
use RuntimeException;
use s9e\TextFormatter\Configurator\Helpers\AVTHelper;
use s9e\TextFormatter\Tests\Test;

/**
* @covers s9e\TextFormatter\Configurator\Helpers\AVTHelper
*/
class AVTHelperTest extends Test
{
	/**
	* @testdox parse() tests
	* @dataProvider getParseTests
	*/
	public function testParse($attrValue, $expected)
	{
		if ($expected instanceof Exception)
		{
			$this->setExpectedException(get_class($expected), $expected->getMessage());
		}

		$this->assertSame($expected, AVTHelper::parse($attrValue));
	}

	public function getParseTests()
	{
		return [
			[
				'',
				[]
			],
			[
				'foo',
				[
					['literal', 'foo']
				]
			],
			[
				'foo {@bar} baz',
				[
					['literal',    'foo '],
					['expression', '@bar'],
					['literal',    ' baz']
				]
			],
			[
				'foo {{@bar}} baz',
				[
					['literal', 'foo '],
					['literal', '{'],
					['literal', '@bar} baz']
				]
			],
			[
				'foo {@bar}{baz} quux',
				[
					['literal',    'foo '],
					['expression', '@bar'],
					['expression', 'baz'],
					['literal',    ' quux']
				]
			],
			[
				'foo {"bar"} baz',
				[
					['literal',    'foo '],
					['expression', '"bar"'],
					['literal',    ' baz']
				]
			],
			[
				"foo {'bar'} baz",
				[
					['literal',    'foo '],
					['expression', "'bar'"],
					['literal',    ' baz']
				]
			],
			[
				'foo {"\'bar\'"} baz',
				[
					['literal',    'foo '],
					['expression', '"\'bar\'"'],
					['literal',    ' baz']
				]
			],
			[
				'foo {"{bar}"} baz',
				[
					['literal',    'foo '],
					['expression', '"{bar}"'],
					['literal',    ' baz']
				]
			],
			[
				'foo {"bar} baz',
				new RuntimeException('Unterminated XPath expression')
			],
			[
				'foo {bar',
				new RuntimeException('Unterminated XPath expression')
			],
			[
				'<foo> {"<bar>"} &amp;',
				[
					['literal',    '<foo> '],
					['expression', '"<bar>"'],
					['literal',    ' &amp;']
				]
			],
		];
	}

	/**
	* @testdox serialize() tests
	* @dataProvider getSerializeTests
	*/
	public function testSerialize($tokens, $expected)
	{
		if ($expected instanceof Exception)
		{
			$this->setExpectedException(get_class($expected), $expected->getMessage());
		}

		$this->assertSame($expected, AVTHelper::serialize($tokens));
	}

	public function getSerializeTests()
	{
		return [
			[
				[['literal', 'foo']],
				'foo'
			],
			[
				[
					['literal',    'foo '],
					['expression', '@bar'],
					['literal',    ' baz']
				],
				'foo {@bar} baz'
			],
			[
				[
					['literal', 'foo '],
					['literal', '{'],
					['literal', '@bar} baz']
				],
				'foo {{@bar}} baz'
			],
			[
				[
					['literal',    'foo '],
					['expression', '@bar'],
					['expression', 'baz'],
					['literal',    ' quux']
				],
				'foo {@bar}{baz} quux'
			],
			[
				[['unknown', 'foo']],
				new RuntimeException('Unknown token type')
			],
			[
				[
					['literal',    '<foo> '],
					['expression', '"<bar>"'],
					['literal',    ' &amp;']
				],
				'<foo> {"<bar>"} &amp;',
			]
		];
	}

	/**
	* @testdox replace() tests
	* @dataProvider getReplaceTests
	*/
	public function testReplace($xml, $callback, $expected)
	{
		if ($expected instanceof Exception)
		{
			$this->setExpectedException(get_class($expected), $expected->getMessage());
		}

		$dom = new DOMDocument;
		$dom->loadXML($xml);

		AVTHelper::replace($dom->documentElement->getAttributeNode('x'), $callback);

		$this->assertSame($expected, $dom->saveXML($dom->documentElement));
	}

	public function getReplaceTests()
	{
		return [
			[
				'<x x="&quot;AT&amp;T&quot;"/>',
				function ($token)
				{
					return $token;
				},
				'<x x="&quot;AT&amp;T&quot;"/>',
			],
			[
				'<x x="{@foo}"/>',
				function ($token)
				{
					return $token;
				},
				'<x x="{@foo}"/>',
			],
			[
				'<x x="X{@X}X"/>',
				function ($token)
				{
					return ['literal', 'x'];
				},
				'<x x="xxx"/>',
			],
		];
	}

	/**
	* @testdox toXSL() tests
	* @dataProvider getToXSLTests
	*/
	public function testToXSL($attrValue, $expected)
	{
		$this->assertSame($expected, AVTHelper::toXSL($attrValue));
	}

	public function getToXSLTests()
	{
		return [
			[
				'',
				''
			],
			[
				'foo',
				'foo'
			],
			[
				'{@foo}',
				'<xsl:value-of select="@foo"/>'
			],
			[
				'{@foo}bar',
				'<xsl:value-of select="@foo"/>bar'
			],
			[
				' {@foo} ',
				'<xsl:text> </xsl:text><xsl:value-of select="@foo"/><xsl:text> </xsl:text>'
			],
			[
				"{'\"'}",
				'<xsl:value-of select="\'&quot;\'"/>'
			],
			[
				'{"\'"}',
				'<xsl:value-of select="&quot;\'&quot;"/>'
			],
			[
				"{'<>'}",
				'<xsl:value-of select="\'&lt;&gt;\'"/>'
			],
			[
				'<"\'>',
				'&lt;"\'&gt;'
			],
		];
	}
}