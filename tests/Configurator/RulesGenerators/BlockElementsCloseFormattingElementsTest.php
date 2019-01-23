<?php

namespace akmaljp\DriveMaru\Tests\Configurator\RulesGenerators;

/**
* @covers akmaljp\DriveMaru\Configurator\RulesGenerators\BlockElementsCloseFormattingElements
*/
class BlockElementsCloseFormattingElementsTest extends AbstractTest
{
	/**
	* @testdox <div> has a closeParent rule for <b>
	*/
	public function testDivCloseB()
	{
		$this->assertTargetedRules(
			'<div><xsl:apply-templates/></div>',
			'<b><xsl:apply-templates/></b>',
			['closeParent']
		);
	}

	/**
	* @testdox <div> does not have a closeParent rule for <div>
	*/
	public function testDivNoCloseDiv()
	{
		$this->assertTargetedRules(
			'<div><xsl:apply-templates/></div>',
			'<div><xsl:apply-templates/></div>',
			[]
		);
	}

	/**
	* @testdox <b> does not have a closeParent rule for <b>
	*/
	public function testBNoCloseB()
	{
		$this->assertTargetedRules(
			'<b><xsl:apply-templates/></b>',
			'<b><xsl:apply-templates/></b>',
			[]
		);
	}
}