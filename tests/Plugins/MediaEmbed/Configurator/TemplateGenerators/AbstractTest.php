<?php

namespace akmaljp\DriveMaru\Tests\Plugins\MediaEmbed\Configurator\TemplateGenerators;

use akmaljp\DriveMaru\Tests\Test;

abstract class AbstractTest extends Test
{
	abstract public function getGetTemplateTests();
	abstract protected function getTemplateGenerator();

	/**
	* @testdox getTemplate() tests
	* @dataProvider getGetTemplateTests
	*/
	public function testGetTemplate(array $attributes, $expected)
	{
		$templateGenerator = $this->getTemplateGenerator();
		$template          = $templateGenerator->getTemplate($attributes);
		$template          = $this->configurator->templateNormalizer->normalizeTemplate($template);

		$this->assertSame($expected, $template);
	}
}