<?php

namespace akmaljp\DriveMaru\Tests\Configurator\RulesGenerators;

/**
* @covers akmaljp\DriveMaru\Configurator\RulesGenerators\EnforceOptionalEndTags
*/
class EnforceOptionalEndTagsTest extends AbstractTest
{
	/**
	* @testdox <li> closes parent <li>
	*/
	public function testLiCloseParentLi()
	{
		$this->assertTargetedRules(
			'<li><xsl:apply-templates/></li>',
			'<li><xsl:apply-templates/></li>',
			['closeParent']
		);
	}

	/**
	* @testdox <ul> closes parent <p>
	*/
	public function testUlCloseParentP()
	{
		$this->assertTargetedRules(
			'<ul><xsl:apply-templates/></ul>',
			'<p><xsl:apply-templates/></p>',
			['closeParent']
		);
	}

	/**
	* @testdox <p> does not close parent <li>
	*/
	public function testPNotCloseParentLi()
	{
		$this->assertTargetedRules(
			'<p><xsl:apply-templates/></p>',
			'<li><xsl:apply-templates/></li>',
			[]
		);
	}
}