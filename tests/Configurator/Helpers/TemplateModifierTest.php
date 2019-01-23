<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Helpers;

use Exception;
use akmaljp\DriveMaru\Configurator\Helpers\TemplateHelper;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Helpers\TemplateHelper
* @covers akmaljp\DriveMaru\Configurator\Helpers\TemplateModifier
*/
class TemplateModifierTest extends Test
{
	/**
	* @testdox replaceTokens() tests
	* @dataProvider replaceTokensTests
	*/
	public function testReplaceTokens($template, $regexp, $fn, $expected)
	{
		if ($expected instanceof Exception)
		{
			$this->setExpectedException(get_class($expected), $expected->getMessage());
		}

		$this->assertSame(
			$expected,
			TemplateHelper::replaceTokens($template, $regexp, $fn, $expected)
		);
	}

	public function replaceTokensTests()
	{
		return [
			[
				'',
				'/foo/',
				function ($m) {},
				''
			],
			[
				'<br/>',
				'/foo/',
				function ($m) {},
				'<br/>'
			],
			[
				'<b title="$1" alt="$2"/>',
				'/\\$[0-9]+/',
				function ($m)
				{
					return ['literal', serialize($m)];
				},
				'<b title="a:1:{i:0;s:2:&quot;$1&quot;;}" alt="a:1:{i:0;s:2:&quot;$2&quot;;}"/>'
			],
			[
				'<b title="$1"/>',
				'/\\$[0-9]+/',
				function ($m)
				{
					return ['expression', '@foo'];
				},
				'<b title="{@foo}"/>'
			],
			[
				'<b title="$1"/>',
				'/\\$[0-9]+/',
				function ($m)
				{
					return ['passthrough'];
				},
				'<b title="{.}"/>'
			],
			[
				'<b title="$1"/>',
				'/\\$[0-9]+/',
				function ($m)
				{
					return ['passthrough', 'X'];
				},
				'<b title="{X}"/>'
			],
			[
				'<b>$1</b>',
				'/\\$[0-9]+/',
				function ($m)
				{
					return ['literal', serialize($m)];
				},
				'<b>a:1:{i:0;s:2:"$1";}</b>'
			],
			[
				'<b>$1</b>',
				'/\\$[0-9]+/',
				function ($m)
				{
					return ['expression', '@foo'];
				},
				'<b><xsl:value-of select="@foo"/></b>'
			],
			[
				'<b>$1</b>',
				'/\\$[0-9]+/',
				function ($m)
				{
					return ['passthrough'];
				},
				'<b><xsl:apply-templates/></b>'
			],
			[
				'<b>$1</b>',
				'/\\$[0-9]+/',
				function ($m)
				{
					return ['passthrough', 'X'];
				},
				'<b><xsl:apply-templates select="X"/></b>'
			],
			[
				'<b id="$1">$1</b>',
				'/\\$[0-9]+/',
				function ($m, $node)
				{
					return ['literal', get_class($node)];
				},
				'<b id="DOMAttr">DOMText</b>'
			],
			[
				'<b>$1</b><i>$$</i>',
				'/\\$[0-9]+/',
				function ($m)
				{
					return ['literal', 'ONE'];
				},
				'<b>ONE</b><i>$$</i>'
			],
			[
				'<b>foo $1 bar</b>',
				'/\\$[0-9]+/',
				function ($m)
				{
					return ['literal', 'ONE'];
				},
				'<b>foo ONE bar</b>'
			],
			[
				'<b>xx</b>',
				'/x/',
				function ($m)
				{
					return ['literal', 'X'];
				},
				'<b>XX</b>'
			],
			[
				'<b>.x.x.</b>',
				'/x/',
				function ($m)
				{
					return ['literal', 'X'];
				},
				'<b>.X.X.</b>'
			],
		];
	}
}