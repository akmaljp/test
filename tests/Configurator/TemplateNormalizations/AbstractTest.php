<?php

namespace akmaljp\DriveMaru\Tests\Configurator\TemplateNormalizations;

use DOMDocument;
use Exception;
use akmaljp\DriveMaru\Configurator\Helpers\TemplateHelper;
use akmaljp\DriveMaru\Tests\Test;

abstract class AbstractTest extends Test
{
	protected function getNormalizer()
	{
		$className  = preg_replace(
			'/.*\\\\(.*?)Test$/',
			'akmaljp\\DriveMaru\\Configurator\\TemplateNormalizations\\\\$1',
			get_class($this)
		);

		return new $className;
	}

	/**
	* @testdox Works
	* @dataProvider getData
	*/
	public function test($template, $expected)
	{
		if ($expected instanceof Exception)
		{
			$this->setExpectedException(get_class($expected), $expected->getMessage() ?: null);
		}

		$xml = '<xsl:template xmlns:xsl="http://www.w3.org/1999/XSL/Transform">'
		     . $template
		     . '</xsl:template>';

		$dom = new DOMDocument;
		$dom->loadXML($xml);

		$this->getNormalizer()->normalize($dom->documentElement);

		$this->assertSame(
			$expected,
			TemplateHelper::saveTemplate($dom)
		);
	}

	abstract public function getData();
}