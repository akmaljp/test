<?php

namespace akmaljp\DriveMaru\Tests\Configurator\RulesGenerators;

/**
* @covers akmaljp\DriveMaru\Configurator\RulesGenerators\DisableAutoLineBreaksIfNewLinesArePreserved
*/
class DisableAutoLineBreaksIfNewLinesArePreservedTest extends AbstractTest
{
	/**
	* @testdox Does not generate a disableAutoLineBreaks rule for <ol>
	*/
	public function testNotDisableAutoLineBreaksOl()
	{
		$this->assertBooleanRules(
			'<ol><xsl:apply-templates/></ol>',
			[]
		);
	}

	/**
	* @testdox Generates a disableAutoLineBreaks rule for <pre>
	*/
	public function testDisableAutoLineBreaksPre()
	{
		$this->assertBooleanRules(
			'<pre><xsl:apply-templates/></pre>',
			['disableAutoLineBreaks' => true]
		);
	}
}