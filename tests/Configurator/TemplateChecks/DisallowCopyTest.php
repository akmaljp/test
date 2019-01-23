<?php

namespace akmaljp\DriveMaru\Tests\Configurator\TemplateChecks;

use DOMDocument;
use DOMElement;
use akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException;
use akmaljp\DriveMaru\Configurator\Items\Tag;
use akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowCopy;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowCopy
*/
class DisallowCopyTest extends Test
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
	* @testdox Disallowed: <b><xsl:copy/></b>
	* @expectedException akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException
	* @expectedExceptionMessage Cannot assess the safety of an 'xsl:copy' element
	*/
	public function test()
	{
		$node = $this->loadTemplate('<b><xsl:copy/></b>');

		try
		{
			$check = new DisallowCopy;
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
	* @testdox Allowed: <b>...</b>
	*/
	public function testAllowed()
	{
		$node = $this->loadTemplate('<b>...</b>');
		$check = new DisallowCopy;
		$check->check($node, new Tag);
	}
}