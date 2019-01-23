<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\Collections\RulesGeneratorList;
use akmaljp\DriveMaru\Configurator\RulesGenerators\AutoCloseIfVoid;
use akmaljp\DriveMaru\Configurator\RulesGenerators\EnforceOptionalEndTags;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Collections\RulesGeneratorList
*/
class RulesGeneratorListTest extends Test
{
	/**
	* @testdox add() normalizes a string into an instance of a class of the same name in akmaljp\DriveMaru\Configurator\RulesGenerators
	*/
	public function testAddNormalizeValue()
	{
		$collection = new RulesGeneratorList;

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\RulesGenerators\\AutoCloseIfVoid',
			$collection->add('AutoCloseIfVoid')
		);
	}

	/**
	* @testdox add() adds BooleanRulesGenerator instances as-is
	*/
	public function testAddInstanceBoolean()
	{
		$collection = new RulesGeneratorList;
		$generator  = new AutoCloseIfVoid;

		$this->assertSame(
			$generator,
			$collection->add($generator)
		);
	}

	/**
	* @testdox add() adds TargetedRulesGenerator instances as-is
	*/
	public function testAddInstanceTargeted()
	{
		$collection = new RulesGeneratorList;
		$generator  = new EnforceOptionalEndTags;

		$this->assertSame(
			$generator,
			$collection->add($generator)
		);
	}

	/**
	* @testdox add() throws an exception on invalid values
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Invalid rules generator 'foo'
	*/
	public function testAddInvalid()
	{
		$collection = new RulesGeneratorList;
		$collection->add('foo');
	}
}