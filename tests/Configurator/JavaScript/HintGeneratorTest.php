<?php

namespace akmaljp\DriveMaru\Tests\Configurator;

use akmaljp\DriveMaru\Configurator\Helpers\ConfigHelper;
use akmaljp\DriveMaru\Configurator\JavaScript\HintGenerator;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\JavaScript\HintGenerator
*/
class HintGeneratorTest extends Test
{
	public function assertHintsContain($str)
	{
		$this->configurator->finalize();
		$config = ConfigHelper::filterConfig($this->configurator->asConfig(), 'JS');

		$xslt = $this->configurator->rendering->engine;
		$xslt->optimizer->normalizer->remove('RemoveLivePreviewAttributes');
		$xsl  = $xslt->getXSL($this->configurator->rendering);

		$generator = new HintGenerator;
		$generator->setConfig($config);
		$generator->setPlugins($this->configurator->plugins);
		$generator->setXSL($xsl);

		$this->assertContains($str, $generator->getHints());
	}

	/**
	* @testdox HINT.attributeDefaultValue=0 by default
	*/
	public function testHintAttributeDefaultValueFalse()
	{
		$this->assertHintsContain('HINT.attributeDefaultValue=0');
	}

	/**
	* @testdox HINT.attributeDefaultValue=1 if any attribute has a defaultValue
	*/
	public function testHintAttributeDefaultValueTrue()
	{
		$this->configurator->tags->add('X')->attributes->add('x')->defaultValue = 0;
		$this->assertHintsContain('HINT.attributeDefaultValue=1');
	}

	/**
	* @testdox HINT.closeAncestor=0 by default
	*/
	public function testHintCloseAncestorFalse()
	{
		$this->assertHintsContain('HINT.closeAncestor=0');
	}

	/**
	* @testdox HINT.closeAncestor=1 if any tag has a closeAncestor rule
	*/
	public function testHintCloseAncestorTrue()
	{
		$this->configurator->tags->add('X')->rules->closeAncestor('X');
		$this->assertHintsContain('HINT.closeAncestor=1');
	}

	/**
	* @testdox HINT.closeParent=0 by default
	*/
	public function testHintCloseParentFalse()
	{
		$this->assertHintsContain('HINT.closeParent=0');
	}

	/**
	* @testdox HINT.closeParent=1 if any tag has a closeParent rule
	*/
	public function testHintCloseParentTrue()
	{
		$this->configurator->tags->add('X')->rules->closeParent('X');
		$this->assertHintsContain('HINT.closeParent=1');
	}

	/**
	* @testdox HINT.createChild=0 by default
	*/
	public function testHintCreateChildFalse()
	{
		$this->assertHintsContain('HINT.createChild=0');
	}

	/**
	* @testdox HINT.createChild=1 if any tag has a createChild rule
	*/
	public function testHintCreateChildTrue()
	{
		$this->configurator->tags->add('X')->rules->createChild('Y');
		$this->assertHintsContain('HINT.createChild=1');
	}

	/**
	* @testdox HINT.fosterParent=0 by default
	*/
	public function testHintFosterParentFalse()
	{
		$this->assertHintsContain('HINT.fosterParent=0');
	}

	/**
	* @testdox HINT.fosterParent=1 if any tag has a fosterParent rule
	*/
	public function testHintFosterParentTrue()
	{
		$this->configurator->tags->add('X')->rules->fosterParent('Y');
		$this->configurator->tags->add('Y');
		$this->assertHintsContain('HINT.fosterParent=1');
	}

	/**
	* @testdox HINT.namespaces=0 by default
	*/
	public function testHintNamespacesFalse()
	{
		$this->assertHintsContain('HINT.namespaces=0');
	}

	/**
	* @testdox HINT.namespaces=1 if any tag has a namespaces rule
	*/
	public function testHintNamespacesTrue()
	{
		$this->configurator->tags->add('foo:X');
		$this->assertHintsContain('HINT.namespaces=1');
	}

	/**
	* @testdox HINT.postProcessing=0 by default
	*/
	public function testHintPostProcessingFalse()
	{
		$this->assertHintsContain('HINT.postProcessing=0');
	}

	/**
	* @testdox HINT.postProcessing=1 if "data-akmaljp-livepreview-postprocess" appears in the stylesheet
	*/
	public function testHintPostProcessingTrue()
	{
		$this->configurator->tags->add('X')->template
			= '<hr data-akmaljp-livepreview-postprocess="foo(this)"/>';
		$this->assertHintsContain('HINT.postProcessing=1');
	}

	/**
	* @testdox HINT.ignoreAttrs=0 by default
	*/
	public function testHintIgnoreAttrsFalse()
	{
		$this->assertHintsContain('HINT.ignoreAttrs=0');
	}

	/**
	* @testdox HINT.ignoreAttrs=1 if "data-akmaljp-livepreview-ignore-attrs" appears in the stylesheet
	*/
	public function testHintIgnoreAttrsTrue()
	{
		$this->configurator->tags->add('X')->template
			= '<hr data-akmaljp-livepreview-ignore-attrs="style"/>';
		$this->assertHintsContain('HINT.ignoreAttrs=1');
	}

	/**
	* @testdox HINT.requireAncestor=0 by default
	*/
	public function testHintRequireAncestorFalse()
	{
		$this->assertHintsContain('HINT.requireAncestor=0');
	}

	/**
	* @testdox HINT.requireAncestor=1 if any tag has a requireAncestor rule
	*/
	public function testHintRequireAncestorTrue()
	{
		$this->configurator->tags->add('X')->rules->requireAncestor('Y');
		$this->assertHintsContain('HINT.requireAncestor=1');
	}

	/**
	* @testdox HINT.RULE_AUTO_CLOSE=0 by default
	*/
	public function testHintRuleAutoCloseFalse()
	{
		$this->assertHintsContain('HINT.RULE_AUTO_CLOSE=0');
	}

	/**
	* @testdox HINT.RULE_AUTO_CLOSE=1 if any tag has an autoClose rule
	*/
	public function testHintRuleAutoCloseTrue()
	{
		$this->configurator->tags->add('X')->rules->autoClose();
		$this->assertHintsContain('HINT.RULE_AUTO_CLOSE=1');
	}

	/**
	* @testdox HINT.RULE_AUTO_REOPEN=0 by default
	*/
	public function testHintRuleAutoReopenFalse()
	{
		$this->assertHintsContain('HINT.RULE_AUTO_REOPEN=0');
	}

	/**
	* @testdox HINT.RULE_AUTO_REOPEN=1 if any tag has an autoReopen rule
	*/
	public function testHintRuleAutoReopenTrue()
	{
		$this->configurator->tags->add('X')->rules->autoReopen();
		$this->assertHintsContain('HINT.RULE_AUTO_REOPEN=1');
	}

	/**
	* @testdox HINT.RULE_BREAK_PARAGRAPH=0 by default
	*/
	public function testHintRuleBreakParagraphFalse()
	{
		$this->assertHintsContain('HINT.RULE_BREAK_PARAGRAPH=0');
	}

	/**
	* @testdox HINT.RULE_BREAK_PARAGRAPH=1 if any tag has a breakParagraph rule
	*/
	public function testHintRuleBreakParagraphsTrue()
	{
		$this->configurator->tags->add('X')->rules->breakParagraph();
		$this->assertHintsContain('HINT.RULE_BREAK_PARAGRAPH=1');
	}

	/**
	* @testdox HINT.RULE_CREATE_PARAGRAPHS=0 by default
	*/
	public function testHintRuleCreateParagraphsFalse()
	{
		$this->assertHintsContain('HINT.RULE_CREATE_PARAGRAPHS=0');
	}

	/**
	* @testdox HINT.RULE_CREATE_PARAGRAPHS=1 if any tag has a createParagraphs rule
	*/
	public function testHintRuleCreateParagraphsTrue()
	{
		$this->configurator->tags->add('X')->rules->createParagraphs();
		$this->assertHintsContain('HINT.RULE_CREATE_PARAGRAPHS=1');
	}

	/**
	* @testdox HINT.RULE_CREATE_PARAGRAPHS=1 if the root rules have a createParagraphs rule
	*/
	public function testHintRuleCreateParagraphsRoot()
	{
		$this->configurator->rootRules->createParagraphs();
		$this->assertHintsContain('HINT.RULE_CREATE_PARAGRAPHS=1');
	}

	/**
	* @testdox HINT.RULE_IGNORE_TEXT=0 by default
	*/
	public function testHintRuleIgnoreTextFalse()
	{
		$this->assertHintsContain('HINT.RULE_IGNORE_TEXT=0');
	}

	/**
	* @testdox HINT.RULE_IGNORE_TEXT=1 if any tag has an ignoreText rule
	*/
	public function testHintRuleIgnoreTextTrue()
	{
		$this->configurator->tags->add('X')->rules->ignoreText();
		$this->assertHintsContain('HINT.RULE_IGNORE_TEXT=1');
	}

	/**
	* @testdox HINT.RULE_IGNORE_TEXT=1 if the root rules have a createParagraphs rule
	*/
	public function testHintRuleIgnoreTextRoot()
	{
		$this->configurator->rootRules->ignoreText();
		$this->assertHintsContain('HINT.RULE_IGNORE_TEXT=1');
	}

	/**
	* @testdox HINT.RULE_IGNORE_WHITESPACE=0 by default
	*/
	public function testHintRuleIgnoreSurroundingWhitespaceFalse()
	{
		$this->assertHintsContain('HINT.RULE_IGNORE_WHITESPACE=0');
	}

	/**
	* @testdox HINT.RULE_IGNORE_WHITESPACE=1 if any tag has an ignoreSurroundingWhitespace rule
	*/
	public function testHintRuleIgnoreSurroundingWhitespaceTrue()
	{
		$this->configurator->tags->add('X')->rules->ignoreSurroundingWhitespace();
		$this->assertHintsContain('HINT.RULE_IGNORE_WHITESPACE=1');
	}

	/**
	* @testdox HINT.RULE_IS_TRANSPARENT=0 by default
	*/
	public function testHintRuleIsTransparentFalse()
	{
		$this->assertHintsContain('HINT.RULE_IS_TRANSPARENT=0');
	}

	/**
	* @testdox HINT.RULE_IS_TRANSPARENT=1 if any tag has an isTransparent rule
	*/
	public function testHintRuleIsTransparentTrue()
	{
		$this->configurator->tags->add('X')->rules->isTransparent();
		$this->assertHintsContain('HINT.RULE_IS_TRANSPARENT=1');
	}

	/**
	* @testdox HINT.RULE_TRIM_FIRST_LINE=0 by default
	*/
	public function testHintRuleTrimFirstLineFalse()
	{
		$this->assertHintsContain('HINT.RULE_TRIM_FIRST_LINE=0');
	}

	/**
	* @testdox HINT.RULE_TRIM_FIRST_LINE=1 if any tag has an trimFirstLine rule
	*/
	public function testHintRuleTrimFirstLineTrue()
	{
		$this->configurator->tags->add('X')->rules->trimFirstLine();
		$this->assertHintsContain('HINT.RULE_TRIM_FIRST_LINE=1');
	}

	/**
	* @testdox Contains hints from plugins
	*/
	public function testPluginHints()
	{
		$mock = $this->getMockBuilder('akmaljp\\DriveMaru\\Plugins\\ConfiguratorBase')
		             ->disableOriginalConstructor()
		             ->getMock();
		$mock->expects($this->atLeastOnce())
		     ->method('getJSHints')
		     ->will($this->returnValue(['FOO' => 1, 'BAR' => false]));

		$this->configurator->plugins['Foo'] = $mock;
		$this->assertHintsContain('HINT.BAR=false');
		$this->assertHintsContain('HINT.FOO=1');
	}
}