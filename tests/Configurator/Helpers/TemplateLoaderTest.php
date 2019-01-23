<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Helpers;

use akmaljp\DriveMaru\Configurator\Helpers\TemplateLoader;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Helpers\TemplateLoader
*/
class TemplateLoaderTest extends Test
{
	/**
	* @testdox load() can load 'foo'
	*/
	public function testLoadText()
	{
		$text = 'foo';

		$dom = TemplateLoader::load($text);
		$this->assertInstanceOf('DOMDocument', $dom);

		$this->assertContains($text, $dom->saveXML());
	}

	/**
	* @testdox save() correctly handles 'foo'
	*/
	public function testSaveText()
	{
		$text = 'foo';

		$this->assertSame($text, TemplateLoader::save(TemplateLoader::load($text)));
	}

	/**
	* @testdox load() can load '<xsl:value-of select="@foo"/>'
	*/
	public function testLoadXSL()
	{
		$xsl = '<xsl:value-of select="@foo"/>';

		$dom = TemplateLoader::load($xsl);
		$this->assertInstanceOf('DOMDocument', $dom);

		$this->assertContains($xsl, $dom->saveXML());
	}

	/**
	* @testdox save() correctly handles '<xsl:value-of select="@foo"/>'
	*/
	public function testSaveXSL()
	{
		$xsl = '<xsl:value-of select="@foo"/>';

		$this->assertSame($xsl, TemplateLoader::save(TemplateLoader::load($xsl)));
	}

	/**
	* @testdox save() correctly handles an empty string
	*/
	public function testSaveXSLEmpty()
	{
		$xsl = '';

		$this->assertSame($xsl, TemplateLoader::save(TemplateLoader::load($xsl)));
	}

	/**
	* @testdox load() can load '<ul><li>one<li>two</ul>'
	*/
	public function testLoadHTML()
	{
		$html = '<ul><li>one<li>two</ul>';
		$xml  = '<ul><li>one</li><li>two</li></ul>';

		$dom = TemplateLoader::load($html);
		$this->assertInstanceOf('DOMDocument', $dom);

		$this->assertContains($xml, $dom->saveXML());
	}

	/**
	* @testdox load() can load '<script>0<1 && 1>0 && alert(1)</script>'
	*/
	public function testLoadHTMLSpecialChars()
	{
		$html = '<script>0<1 && 1>0 && alert(1)</script>';
		$xml  = '<script><![CDATA[0<1 && 1>0 && alert(1)]]></script>';

		$dom = TemplateLoader::load($html);
		$this->assertInstanceOf('DOMDocument', $dom);

		$this->assertContains($xml, $dom->saveXML());
	}

	/**
	* @testdox load() can load '<ul><li>one<li>two</ul>'
	* @depends testLoadHTML
	*/
	public function testLoadHTMLInNamespace()
	{
		$html = '<ul><li>one<li>two</ul>';

		$this->assertSame(
			'http://www.w3.org/1999/XSL/Transform',
			TemplateLoader::load($html)->lookupNamespaceURI('xsl')
		);
	}

	/**
	* @testdox load() accepts unescaped ampersands
	*/
	public function testLoadAmpersands()
	{
		$template = '<a href="foo?bar=&baz="><xsl:apply-templates/></a>';
		$xml      = '<a href="foo?bar=&amp;baz="><xsl:apply-templates/></a>';

		$dom = TemplateLoader::load($template);
		$this->assertInstanceOf('DOMDocument', $dom);

		$this->assertSame($xml, $dom->saveXML($dom->documentElement->firstChild));
	}

	/**
	* @testdox load() converts HTML entities
	*/
	public function testLoadEntities()
	{
		$template = '<b title="&&eacute;;"><xsl:apply-templates/></b>';
		$xml      = '<b title="&amp;é;"><xsl:apply-templates/></b>';

		$dom = TemplateLoader::load($template);
		$this->assertInstanceOf('DOMDocument', $dom);

		$this->assertSame($xml, $dom->saveXML($dom->documentElement->firstChild));
	}

	/**
	* @testdox load() does not break numeric character references
	*/
	public function testLoadNumericCharacterReferences()
	{
		$template = '<b title="&&#x4C;&#x4f;&#76;;"><xsl:apply-templates/></b>';
		$xml      = '<b title="&amp;LOL;"><xsl:apply-templates/></b>';

		$dom = TemplateLoader::load($template);
		$this->assertInstanceOf('DOMDocument', $dom);

		$this->assertSame($xml, $dom->saveXML($dom->documentElement->firstChild));
	}

	/**
	* @testdox load() removes attributes with an invalid name
	*/
	public function testLoadAttributeInvalidName()
	{
		$template = '<div class="inline" padding:0>..</div>';
		$xml      = '<div class="inline">..</div>';

		$dom = TemplateLoader::load($template);
		$this->assertInstanceOf('DOMDocument', $dom);

		$this->assertSame($xml, $dom->saveXML($dom->documentElement->firstChild));
	}

	/**
	* @testdox load() removes attributes with an invalid namespace in XML
	*/
	public function testLoadAttributeInvalidNamespaceXML()
	{
		$template = '<div foo:bar:baz="1" title="" x:y:z="1">..</div>';

		$dom = TemplateLoader::load($template);
		$xml = $dom->saveXML($dom->documentElement->firstChild);

		$this->assertInstanceOf('DOMDocument', $dom);
		$this->assertContains('title=""',       $xml);
		$this->assertNotContains('foo:bar:baz', $xml);
		$this->assertNotContains('x:y:z',       $xml);
	}

	/**
	* @testdox load() removes attributes with an invalid namespace in HTML
	*/
	public function testLoadAttributeInvalidNamespaceHTML()
	{
		$template = '<div foo:bar:baz="1" title="" x:y:z="1"><br></div>';

		$dom = TemplateLoader::load($template);
		$xml = $dom->saveXML($dom->documentElement->firstChild);

		$this->assertInstanceOf('DOMDocument', $dom);
		$this->assertContains('title=""',       $xml);
		$this->assertNotContains('foo:bar:baz', $xml);
		$this->assertNotContains('x:y:z',       $xml);
	}

	/**
	* @testdox save() correctly handles '<ul><li>one<li>two</ul>'
	*/
	public function testSaveHTML()
	{
		$html = '<ul><li>one<li>two</ul>';
		$xml  = '<ul><li>one</li><li>two</li></ul>';

		$this->assertSame($xml, TemplateLoader::save(TemplateLoader::load($html)));
	}

	/**
	* @testdox load() throws an exception on malformed XSL
	* @expectedException RuntimeException
	* @expectedExceptionMessage Invalid XSL: Premature end of data
	*/
	public function testLoadInvalidXSL()
	{
		$xsl = '<xsl:value-of select="@foo">';
		TemplateLoader::load($xsl);
	}

	/**
	* @testdox load() reads HTML as UTF-8
	*/
	public function testLoadUnicodeHTML()
	{
		$template = '<b title=foo>Pokémon</b>';
		$xml      = '<b title="foo">Pokémon</b>';

		$dom = TemplateLoader::load($template);
		$this->assertInstanceOf('DOMDocument', $dom);

		$this->assertSame($xml, $dom->saveXML($dom->documentElement->firstChild));
	}
}