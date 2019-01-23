<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\Collections\TagList;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Collections\TagList
*/
class TagListTest extends Test
{
	/**
	* @testdox Tag names are normalized for storage
	*/
	public function testNamesAreNormalizedForStorage()
	{
		$tagList = new TagList;
		$tagList->append('UrL');

		$this->assertTrue($tagList->contains('URL'));
	}

	/**
	* @testdox Tag names are normalized during retrieval
	*/
	public function testNamesAreNormalizedDuringRetrieval()
	{
		$tagList = new TagList;
		$tagList->append('UrL');

		$this->assertTrue($tagList->contains('uRl'));
	}

	/**
	* @testdox asConfig() returns a deduplicated list of tag names
	*/
	public function testAsConfigDedupes()
	{
		$tagList = new TagList;
		$tagList->append('URL');
		$tagList->append('URL');

		$this->assertSame(
			['URL'],
			$tagList->asConfig()
		);
	}

	/**
	* @testdox asConfig() returns a list of tag names in alphabetical order
	*/
	public function testAsConfigSort()
	{
		$tagList = new TagList;
		$tagList->append('URL');
		$tagList->append('B');
		$tagList->append('I');

		$this->assertSame(
			['B', 'I', 'URL'],
			$tagList->asConfig()
		);
	}
}