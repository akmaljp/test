<?php

namespace akmaljp\DriveMaru\Tests\Renderers;

use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Renderers\Unformatted
*/
class UnformattedTest extends Test
{
	/**
	* @testdox Returns unformatted version of rich text
	*/
	public function testRichText()
	{
		$this->configurator->rendering->engine = 'Unformatted';
		$renderer = $this->configurator->rendering->getRenderer();

		$this->assertSame(
			'bold',
			$renderer->render("<r><B><s>[b]</s>bold<e>[/b]</e></B></r>")
		);
	}

	/**
	* @testdox Converts newlines to <br>
	*/
	public function testNl2brHTML()
	{
		$this->configurator->rendering->engine = 'Unformatted';
		$renderer = $this->configurator->rendering->getRenderer();

		$this->assertSame(
			"a<br>\nb",
			$renderer->render("<r>a\nb</r>")
		);
	}

	/**
	* @testdox Keeps HTML's special characters escaped
	*/
	public function testPreservesSpecialChars()
	{
		$this->configurator->rendering->engine = 'Unformatted';
		$renderer = $this->configurator->rendering->getRenderer();

		$this->assertSame(
			'AT&amp;T &lt;b&gt;',
			$renderer->render("<r>AT&amp;T &lt;b&gt;</r>")
		);
	}

	/**
	* @testdox Escapes unescaped special characters
	*/
	public function testEncodesSpecialChars()
	{
		$this->configurator->rendering->engine = 'Unformatted';
		$renderer = $this->configurator->rendering->getRenderer();

		$this->assertSame(
			'AT&amp;T &lt;b&gt; &amp; &lt; &gt;',
			$renderer->render('AT&amp;T &lt;b&gt; & < >')
		);
	}

	/**
	* @testdox setParameter() doesn't do anything
	*/
	public function testSetParameter()
	{
		$this->configurator->rendering->engine = 'Unformatted';
		$this->configurator->rendering->getRenderer()->setParameter('foo', 'bar');
	}
}