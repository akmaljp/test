<?php

namespace akmaljp\DriveMaru\Tests\Configurator\RulesGenerators;

/**
* @covers akmaljp\DriveMaru\Configurator\RulesGenerators\AutoCloseIfVoid
*/
class AutoCloseIfVoidTest extends AbstractTest
{
	/**
	* @testdox Generates an autoClose rule for <hr/>
	*/
	public function testAutoClose()
	{
		$this->assertBooleanRules(
			'<hr/>',
			['autoClose' => true]
		);
	}

	/**
	* @testdox Does not generate an autoClose rule for <span>
	*/
	public function testNoAutoClose()
	{
		$this->assertBooleanRules(
			'<span><xsl:apply-templates/></span>',
			[]
		);
	}
}