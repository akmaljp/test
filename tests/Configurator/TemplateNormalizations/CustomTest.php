<?php

namespace akmaljp\DriveMaru\Tests\Configurator\TemplateNormalizations;

use DOMDocument;
use akmaljp\DriveMaru\Configurator\TemplateNormalizations\Custom;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\TemplateNormalizations\Custom
*/
class CustomTest extends Test
{
	/**
	* @testdox normalize() calls the user-defined callback with a DOMElement as argument
	*/
	public function testNormalize()
	{
		$dom = new DOMDocument;
		$dom->loadXML('<x/>');

		$mock = $this->getMockBuilder('stdClass')
		             ->setMethods(['foo'])
		             ->getMock();
		$mock->expects($this->once())
		     ->method('foo')
		     ->with($dom->documentElement);

		$normalizer = new Custom([$mock, 'foo']);
		$normalizer->normalize($dom->documentElement);
	}
}