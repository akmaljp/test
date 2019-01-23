<?php

namespace akmaljp\DriveMaru\Tests\Configurator\TemplateChecks;

use DOMDocument;
use DOMElement;
use akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException;
use akmaljp\DriveMaru\Configurator\Items\Tag;
use akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowAttributeSets;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowAttributeSets
*/
class DisallowAttributeSetsTest extends Test
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
	* @testdox Disallowed: <b use-attribute-sets="foo"/>
	* @expectedException akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException
	* @expectedExceptionMessage Cannot assess the safety of attribute sets
	*/
	public function test()
	{
		$node = $this->loadTemplate('<b use-attribute-sets="foo"/>');

		try
		{
			$check = new DisallowAttributeSets;
			$check->check($node, new Tag);
		}
		catch (UnsafeTemplateException $e)
		{
			$this->assertTrue(
				$e->getNode()->isSameNode(
					$node->firstChild->getAttributeNode('use-attribute-sets')
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
		$check = new DisallowAttributeSets;
		$check->check($node, new Tag);
	}
}