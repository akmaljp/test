<?php

namespace akmaljp\DriveMaru\Tests\Plugins\MediaEmbed\Configurator\TemplateGenerators;

use akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator\TemplateBuilder;
use akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator\TemplateGenerators\Choose;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator\TemplateGenerator
* @covers akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator\TemplateGenerators\Choose
*/
class ChooseTest extends Test
{
	/**
	* @testdox getTemplate() with one when / one otherwise
	*/
	public function testGetTemplateOneWhen()
	{
		$mock = $this->getMockBuilder('akmaljp\\DriveMaru\\Plugins\\MediaEmbed\\Configurator\\TemplateBuilder')
		             ->setMethods(['getTemplate'])
		             ->getMock();
		$mock->expects($this->at(0))
		     ->method('getTemplate')
		     ->will($this->returnValue('foo'));
		$mock->expects($this->at(1))
		     ->method('getTemplate')
		     ->will($this->returnValue('bar'));

		$attributes = [
			'when' => [
				'test'   => '@foo',
				'iframe' => ['src' => 'foo']
			],
			'otherwise' => [
				'iframe' => ['src' => 'bar']
			]
		];
		$expected = '<xsl:choose><xsl:when test="@foo">foo</xsl:when><xsl:otherwise>bar</xsl:otherwise></xsl:choose>';

		$templateGenerator = new Choose($mock);
		$template          = $templateGenerator->getTemplate($attributes);
		$template          = $this->configurator->templateNormalizer->normalizeTemplate($template);

		$this->assertSame($expected, $template);
	}

	/**
	* @testdox getTemplate() with two when / one otherwise
	*/
	public function testGetTemplateTwoWhen()
	{
		$mock = $this->getMockBuilder('akmaljp\\DriveMaru\\Plugins\\MediaEmbed\\Configurator\\TemplateBuilder')
		             ->setMethods(['getTemplate'])
		             ->getMock();
		$mock->expects($this->at(0))
		     ->method('getTemplate')
		     ->will($this->returnValue('foo'));
		$mock->expects($this->at(1))
		     ->method('getTemplate')
		     ->will($this->returnValue('bar'));
		$mock->expects($this->at(2))
		     ->method('getTemplate')
		     ->will($this->returnValue('baz'));

		$attributes = [
			'when' => [
				[
					'test'   => '@foo',
					'iframe' => ['src' => 'foo']
				],
				[
					'test'   => '@bar',
					'iframe' => ['src' => 'bar']
				]
			],
			'otherwise' => [
				'iframe' => ['src' => 'baz']
			]
		];
		$expected = '<xsl:choose><xsl:when test="@foo">foo</xsl:when><xsl:when test="@bar">bar</xsl:when><xsl:otherwise>baz</xsl:otherwise></xsl:choose>';

		$templateGenerator = new Choose($mock);
		$template          = $templateGenerator->getTemplate($attributes);
		$template          = $this->configurator->templateNormalizer->normalizeTemplate($template);

		$this->assertSame($expected, $template);
	}
}