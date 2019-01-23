<?php

namespace akmaljp\DriveMaru\Tests\Configurator\TemplateChecks;

use DOMDocument;
use DOMElement;
use akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException;
use akmaljp\DriveMaru\Configurator\Items\Tag;
use akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowDynamicElementNames;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowDynamicElementNames
*/
class DisallowDynamicElementNamesTest extends Test
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
	* @testdox Disallowed: <xsl:element name="{s}"/>
	* @expectedException akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException
	* @expectedExceptionMessage Dynamic <xsl:element/> names are disallowed
	*/
	public function testDisallowed()
	{
		$node = $this->loadTemplate('<xsl:element name="{s}"/>');

		try
		{
			$check = new DisallowDynamicElementNames;
			$check->check($node, new Tag);
		}
		catch (UnsafeTemplateException $e)
		{
			$this->assertTrue(
				$e->getNode()->isSameNode(
					$node->firstChild
				)
			);

			throw $e;
		}
	}

	/**
	* @testdox Allowed: <xsl:element name="b"/>
	*/
	public function testAllowed()
	{
		$node = $this->loadTemplate('<xsl:element name="b"/>');

		$check = new DisallowDynamicElementNames;
		$check->check($node, new Tag);
	}
}