<?php

namespace akmaljp\DriveMaru\Tests\Configurator\RulesGenerators;

/**
* @covers akmaljp\DriveMaru\Configurator\RulesGenerators\IgnoreWhitespaceAroundBlockElements
*/
class IgnoreWhitespaceAroundBlockElementsTest extends AbstractTest
{
	/**
	* @testdox Generates a ignoreSurroundingWhitespace rule for <div>
	*/
	public function testIgnoreSurroundingWhitespace()
	{
		$this->assertBooleanRules(
			'<div><xsl:apply-templates/></div>',
			['ignoreSurroundingWhitespace' => true]
		);
	}

	/**
	* @testdox Does not generate a ignoreSurroundingWhitespace rule for <span>
	*/
	public function testNoIgnoreSurroundingWhitespace()
	{
		$this->assertBooleanRules(
			'<span><xsl:apply-templates/></span>',
			[]
		);
	}
}