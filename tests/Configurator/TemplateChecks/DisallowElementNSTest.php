<?php

namespace akmaljp\DriveMaru\Tests\Configurator\TemplateChecks;

use DOMDocument;
use DOMElement;
use akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException;
use akmaljp\DriveMaru\Configurator\Items\Tag;
use akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowElementNS;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowElementNS
*/
class DisallowElementNSTest extends Test
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
	* @testdox DisallowElementNS('http://www.w3.org/2000/svg', 'svg') disallows <svg:svg xmlns:svg="http://www.w3.org/2000/svg"/>
	* @expectedException akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException
	* @expectedExceptionMessage Element 'svg:svg' is disallowed
	*/
	public function testDisallowed()
	{
		$node = $this->loadTemplate('<svg:svg xmlns:svg="http://www.w3.org/2000/svg"/>');

		try
		{
			$check = new DisallowElementNS('http://www.w3.org/2000/svg', 'svg');
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
	* @testdox DisallowElementNS('http://www.w3.org/2000/svg', 'svg') disallows <svg xmlns="http://www.w3.org/2000/svg"/>
	* @expectedException akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException
	* @expectedExceptionMessage Element 'svg' is disallowed
	*/
	public function testDisallowedDefaultNS()
	{
		$node = $this->loadTemplate('<svg xmlns="http://www.w3.org/2000/svg"/>');

		try
		{
			$check = new DisallowElementNS('http://www.w3.org/2000/svg', 'svg');
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
	* @testdox DisallowElementNS('urn:foo', 'script') allows <b><script/></b>
	*/
	public function testAllowed()
	{
		$node = $this->loadTemplate('<b><script/></b>');

		$check = new DisallowElementNS('urn:foo', 'script');
		$check->check($node, new Tag);
	}
}