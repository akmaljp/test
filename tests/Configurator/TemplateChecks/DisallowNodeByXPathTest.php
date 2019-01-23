<?php

namespace akmaljp\DriveMaru\Tests\Configurator\TemplateChecks;

use DOMDocument;
use DOMElement;
use akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException;
use akmaljp\DriveMaru\Configurator\Items\Tag;
use akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowNodeByXPath;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowNodeByXPath
*/
class DisallowNodeByXPathTest extends Test
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
	* @testdox '//script[@src]' disallows <div><script src=""/></div>
	* @expectedException akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException
	* @expectedExceptionMessage Node 'script' is disallowed because it matches '//script[@src]'
	*/
	public function testDisallowed()
	{
		$node = $this->loadTemplate('<div><script src=""/></div>');

		try
		{
			$check = new DisallowNodeByXPath('//script[@src]');
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
	* @testdox '//script[@src]' allows <div><script/></div>
	*/
	public function testAllowed()
	{
		$node = $this->loadTemplate('<div><script/></div>');
		$check = new DisallowNodeByXPath('//script[@src]');
		$check->check($node, new Tag);
	}
}