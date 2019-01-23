<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\Collections\TemplateParameterCollection;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Collections\TemplateParameterCollection
*/
class TemplateParameterCollectionTest extends Test
{
	/**
	* @testdox add('foo') adds parameter 'foo' with an empty value
	*/
	public function testAddNoValue()
	{
		$collection = new TemplateParameterCollection;
		$collection->add('foo');

		$this->assertSame('', $collection->get('foo'));
	}

	/**
	* @testdox add('foo', 1) adds parameter 'foo' with value '1'
	*/
	public function testAdd()
	{
		$collection = new TemplateParameterCollection;
		$collection->add('foo', 1);

		$this->assertSame('1', $collection->get('foo'));
	}

	/**
	* @testdox add('foo bar') throws an exception
	* @expectedException InvalidArgumentException
	*/
	public function testAddInvalid()
	{
		$collection = new TemplateParameterCollection;
		$collection->add('foo bar');
	}
}