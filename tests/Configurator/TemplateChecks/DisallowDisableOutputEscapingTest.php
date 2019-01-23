<?php

namespace akmaljp\DriveMaru\Tests\Configurator\TemplateChecks;

use DOMDocument;
use DOMElement;
use akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException;
use akmaljp\DriveMaru\Configurator\Items\Tag;
use akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowDisableOutputEscaping;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowDisableOutputEscaping
*/
class DisallowDisableOutputEscapingTest extends Test
{
	protected function loadTemplate($template)
	{
		$xml = '<xsl:template xmlns:xsl="http://www.w3.org/1999/XSL/Transform">'
		     . $template
		     . '</xsl:template>';

		$dom = new DOMDocument;
		$dom->loadXML($xml);

		return $dom->documentElement;
	}

	/**
	* @testdox Disallowed: <b disable-output-escaping="1"/>
	* @expectedException akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException
	* @expectedExceptionMessage The template contains a 'disable-output-escaping' attribute
	*/
	public function test()
	{
		$node = $this->loadTemplate('<b disable-output-escaping="1"/>');

		try
		{
			$check = new DisallowDisableOutputEscaping;
			$check->check($node, new Tag);
		}
		catch (UnsafeTemplateException $e)
		{
			$this->assertTrue(
				$e->getNode()->isSameNode(
					$node->firstChild->getAttributeNode('disable-output-escaping')
				)
			);

			throw $e;
		}
	}

	/**
	* @testdox Allowed: <b>...</b>
	*/
	public function testAllowed()
	{
		$node = $this->loadTemplate('<b>...</b>');
		$check = new DisallowDisableOutputEscaping;
		$check->check($node, new Tag);
	}
}