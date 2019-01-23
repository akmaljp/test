<?php

namespace akmaljp\DriveMaru\Tests\Renderers;

use DOMNode;
use ReflectionObject;
use akmaljp\DriveMaru\Renderers\PHP;
use akmaljp\DriveMaru\Tests\RendererTests;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Renderer
* @covers akmaljp\DriveMaru\Renderers\PHP
*/
class PHPTest extends Test
{
	use RendererTests;

	public function setUp()
	{
		$this->configurator->rendering->engine = 'PHP';
	}

	/**
	* @testdox Is serializable
	*/
	public function testSerializable()
	{
		$this->configurator->rendering->parameters->add('foo', "'bar'");
		$renderer = $this->configurator->rendering->getRenderer();

		$this->assertEquals(
			$renderer,
			unserialize(serialize($renderer))
		);
	}

	/**
	* @testdox The source of the renderer is omitted for serialization
	*/
	public function testNoSourceSerialize()
	{
		$renderer = $this->configurator->rendering->getRenderer();

		$this->assertNotContains('source', serialize($renderer));
	}

	/**
	* @testdox The last output of the renderer is omitted for serialization
	*/
	public function testNoOutputSerialize()
	{
		$renderer = $this->configurator->rendering->getRenderer();
		$renderer->render('<r>xxx</r>');

		$this->assertNotContains('out', serialize($renderer));
	}

	/**
	* @testdox Internal objects and resources are unset after rendering
	*/
	public function testResourcesUnset()
	{
		// Create a template that requires XPath
		$this->configurator->tags->add('FOO')->template = '<xsl:value-of select="lang()"/>';

		$renderer = $this->configurator->rendering->getRenderer();
		$renderer->render('<r>xxx</r>');

		$reflection = new ReflectionObject($renderer);
		foreach ($reflection->getProperties() as $prop)
		{
			if ($prop->isStatic())
			{
				continue;
			}

			$this->assertAttributeNotInternalType(
				'object',
				$prop->getName(),
				$renderer
			);
			$this->assertAttributeNotInternalType(
				'resource',
				$prop->getName(),
				$renderer
			);
		}
	}

	/**
	* @testdox The abstract renderer has a default implementation for renderQuickTemplate()
	* @expectedException RuntimeException
	* @expectedExceptionMessage Not implemented
	*/
	public function testDefaultQuickTemplate()
	{
		$renderer = new DummyRenderer;
		$renderer->callRenderQuickTemplate();
	}

	/**
	* @testdox render() throws an exception on invalid XML with a "r" root tag that could be rendered by the Quick renderer
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Cannot load XML: Premature end of data in tag r
	*/
	public function testInvalidXMLQuick()
	{
		$this->configurator->rendering->getRenderer()->render('<r>');
	}
}

class DummyRenderer extends PHP
{
	public function callRenderQuickTemplate()
	{
		$this->renderQuickTemplate('x', '<x>');
	}

	protected function renderNode(DOMNode $node)
	{
	}
}