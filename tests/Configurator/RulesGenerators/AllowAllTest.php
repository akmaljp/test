<?php

namespace akmaljp\DriveMaru\Tests\Configurator\RulesGenerators;

/**
* @covers akmaljp\DriveMaru\Configurator\RulesGenerators\AllowAll
*/
class AllowAllTest extends AbstractTest
{
	/**
	* @testdox <b> has a allowChild rule and a allowDescendant rule for <div>
	*/
	public function testAllowAll()
	{
		$this->assertTargetedRules(
			'<b><xsl:apply-templates/></b>',
			'<div><xsl:apply-templates/></div>',
			['allowChild', 'allowDescendant']
		);
	}
}