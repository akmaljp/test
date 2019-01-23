<?php

namespace akmaljp\DriveMaru\Tests\Configurator\RendererGenerators\PHP;

use akmaljp\DriveMaru\Configurator\RendererGenerators\PHP\SwitchStatement;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\RendererGenerators\PHP\SwitchStatement
*/
class SwitchStatementTest extends Test
{
	/**
	* @testdox generate() tests
	* @dataProvider getGenerateTests
	*/
	public function testGenerate($expr, array $branchesCode, $defaultCode, $expected)
	{
		$this->assertSame($expected, SwitchStatement::generate($expr, $branchesCode, $defaultCode));
	}

	public function getGenerateTests()
	{
		return [
			[
				'$x',
				['bar' => "\$html.='bar';", 'foo' => "\$html.='foo';"],
				'',
				"switch(\$x){case'bar':\$html.='bar';break;case'foo':\$html.='foo';}"
			],
			[
				'$x',
				['foo' => "\$html.='foo';", 'bar' => "\$html.='bar';"],
				'',
				"switch(\$x){case'bar':\$html.='bar';break;case'foo':\$html.='foo';}"
			],
			[
				'$x',
				['foo' => "\$html.='foo';", 'bar' => "\$html.='bar';"],
				"\$html.='baz';",
				"switch(\$x){case'bar':\$html.='bar';break;case'foo':\$html.='foo';break;default:\$html.='baz';}"
			],
			[
				'$x',
				['foo' => "\$html.='foo';", 'bar' => "\$html.='foo';"],
				"\$html.='baz';",
				"switch(\$x){case'bar':case'foo':\$html.='foo';break;default:\$html.='baz';}"
			],
		];
	}
}