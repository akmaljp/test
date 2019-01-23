<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items;

use akmaljp\DriveMaru\Configurator\Items\AttributePreprocessor;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\AttributePreprocessor
*/
class AttributePreprocessorTest extends Test
{
	/**
	* @testdox __construct() throws an InvalidArgumentException if the regexp is not valid
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Invalid regular expression
	*/
	public function testInvalidRegexp()
	{
		new AttributePreprocessor('(?)');
	}

	/**
	* @testdox getAttributes() returns an array where keys are the name of the named subpatterns/attributes and values is the regexp that exactly matches them
	*/
	public function testGetAttributes()
	{
		$ap = new AttributePreprocessor('#(?<year>\\d{4}) (?<name>[a-z]+)#');

		$this->assertSame(
			[
				'year' => '#^\\d{4}$#D',
				'name' => '#^[a-z]+$#D'
			],
			$ap->getAttributes()
		);
	}

	/**
	* @testdox getAttributes() preserves the original's regexp "i", "s" and "u" flags
	*/
	public function testGetAttributesFlags()
	{
		$ap = new AttributePreprocessor('#(?<year>\\d{4}) (?<name>[a-z]+)#Disu');

		$this->assertSame(
			[
				'year' => '#^\\d{4}$#Disu',
				'name' => '#^[a-z]+$#Disu'
			],
			$ap->getAttributes()
		);
	}

	/**
	* @testdox getRegexp() returns the regexp associated with this attribute preprocessor
	*/
	public function testGetRegexp()
	{
		$ap = new AttributePreprocessor('#(?<x>[a-z])#');

		$this->assertSame('#(?<x>[a-z])#', $ap->getRegexp());
	}
}