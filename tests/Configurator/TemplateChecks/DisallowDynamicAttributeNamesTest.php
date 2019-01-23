<?php

namespace akmaljp\DriveMaru\Tests\Configurator\TemplateChecks;

use DOMDocument;
use DOMElement;
use akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException;
use akmaljp\DriveMaru\Configurator\Items\Tag;
use akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowDynamicAttributeNames;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowDynamicAttributeNames
*/
class DisallowDynamicAttributeNamesTest extends Test
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
	* @testdox Disallowed: <b><xsl:attribute name="{@foo}"/></b>
	* @expectedException akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException
	* @expectedExceptionMessage Dynamic <xsl:attribute/> names are disallowed
	*/
	public function testDisallowed()
	{
		$node = $this->loadTemplate('<b><xsl:attribute name="{@foo}"/></b>');

		try
		{
			$check = new DisallowDynamicAttributeNames;
			$check->check($node, new Tag);
		}
		catch (UnsafeTemplateException $e)
		{
			$this->assertTrue(
				$e->getNode()->isSameNode(
					$node->firstChild->firstChild
				)
			);

			throw $e;
		}
	}

	/**
	* @testdox Allowed: <b><xsl:attribute name="title"/></b>
	*/
	public function testAllowed()
	{
		$node = $this->loadTemplate('<b><xsl:attribute name="title"/></b>');

		$check = new DisallowDynamicAttributeNames;
		$check->check($node, new Tag);
	}
}