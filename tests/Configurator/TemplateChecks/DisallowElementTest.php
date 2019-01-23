<?php

namespace akmaljp\DriveMaru\Tests\Configurator\TemplateChecks;

use DOMDocument;
use DOMElement;
use akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException;
use akmaljp\DriveMaru\Configurator\Items\Tag;
use akmaljp\DriveMaru\Configurator\Items\Template;
use akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowElement;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowElement
*/
class DisallowElementTest extends Test
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
	* @testdox DisallowElement('script') disallows <b><script/></b>
	* @expectedException akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException
	* @expectedExceptionMessage Element 'script' is disallowed
	*/
	public function testDisallowed()
	{
		$node = $this->loadTemplate('<b><script/></b>');

		try
		{
			$check = new DisallowElement('script');
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
	* @testdox DisallowElement('svg') disallows <svg:svg xmlns:svg="http://www.w3.org/2000/svg"/>
	* @expectedException akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException
	* @expectedExceptionMessage Element 'svg' is disallowed
	*/
	public function testDisallowedNS()
	{
		$node = $this->loadTemplate('<svg:svg xmlns:svg="http://www.w3.org/2000/svg"/>');

		try
		{
			$check = new DisallowElement('svg');
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
	* @testdox DisallowElement('script') allows <b><span/></b>
	*/
	public function testAllowed()
	{
		$node = $this->loadTemplate('<b><span/></b>');

		$check = new DisallowElement('script');
		$check->check($node, new Tag);
	}

	/**
	* @testdox DisallowElement('script') disallows <b><SCRIPT/></b>
	* @expectedException akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException
	* @expectedExceptionMessage Element 'script' is disallowed
	*/
	public function testDisallowedUppercase()
	{
		$node = $this->loadTemplate('<b><SCRIPT/></b>');

		try
		{
			$check = new DisallowElement('script');
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
	* @testdox DisallowElement('script') disallows <b><xsl:element name="script"/></b>
	* @expectedException akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException
	* @expectedExceptionMessage Element 'script' is disallowed
	*/
	public function testDisallowedDynamic()
	{
		$node = $this->loadTemplate('<b><xsl:element name="script"/></b>');

		try
		{
			$check = new DisallowElement('script');
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
}