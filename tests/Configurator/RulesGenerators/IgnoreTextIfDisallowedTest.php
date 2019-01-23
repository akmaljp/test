<?php

namespace akmaljp\DriveMaru\Tests\Configurator\RulesGenerators;

/**
* @covers akmaljp\DriveMaru\Configurator\RulesGenerators\IgnoreTextIfDisallowed
*/
class IgnoreTextIfDisallowedTest extends AbstractTest
{
	/**
	* @testdox Generates an ignoreText rule for <ul>
	*/
	public function testIgnoreText()
	{
		$this->assertBooleanRules(
			'<ul><xsl:apply-templates/></ul>',
			['ignoreText' => true]
		);
	}

	/**
	* @testdox Does not generate an ignoreText rule for <b>
	*/
	public function testNotIgnoreText()
	{
		$this->assertBooleanRules(
			'<b><xsl:apply-templates/></b>',
			[]
		);
	}
}