<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\Collections\TagFilterChain;
use akmaljp\DriveMaru\Configurator\Items\Tag;
use akmaljp\DriveMaru\Configurator\Items\TagFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Collections\FilterChain
* @covers akmaljp\DriveMaru\Configurator\Collections\TagFilterChain
*/
class TagFilterChainTest extends Test
{
	private function privateMethod() {}
	public function doNothing() {}

	/**
	* @testdox append() throws an InvalidArgumentException on invalid callbacks
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Filter '*invalid*' is neither callable nor an instance of akmaljp\DriveMaru\Configurator\Items\TagFilter
	*/
	public function testAppendInvalidCallback()
	{
		$filterChain = new TagFilterChain;
		$filterChain->append('*invalid*');
	}

	/**
	* @testdox prepend() throws an InvalidArgumentException on invalid callbacks
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Filter '*invalid*' is neither callable nor an instance of akmaljp\DriveMaru\Configurator\Items\TagFilter
	*/
	public function testPrependInvalidCallback()
	{
		$filterChain = new TagFilterChain;
		$filterChain->prepend('*invalid*');
	}

	/**
	* @testdox append() throws an InvalidArgumentException on uncallable callbacks
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage is neither callable nor an instance of akmaljp\DriveMaru\Configurator\Items\TagFilter
	*/
	public function testAppendUncallableCallback()
	{
		$filterChain = new TagFilterChain;
		$filterChain->append([__CLASS__, 'privateMethod']);
	}

	/**
	* @testdox prepend() throws an InvalidArgumentException on uncallable callbacks
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage is neither callable nor an instance of akmaljp\DriveMaru\Configurator\Items\TagFilter
	*/
	public function testPrependUncallableCallback()
	{
		$filterChain = new TagFilterChain;
		$filterChain->prepend([__CLASS__, 'privateMethod']);
	}

	/**
	* @testdox PHP string callbacks are normalized to an instance of TagFilter
	*/
	public function testStringCallback()
	{
		$filterChain = new TagFilterChain;

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Items\\TagFilter',
			$filterChain->append('strtolower')
		);
	}

	/**
	* @testdox PHP array callbacks are normalized to an instance of TagFilter
	*/
	public function testArrayCallback()
	{
		$filterChain = new TagFilterChain;

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Items\\TagFilter',
			$filterChain->append([$this, 'doNothing'])
		);
	}

	/**
	* @testdox Instances of TagFilter are added as-is
	*/
	public function testTagFilterInstance()
	{
		$filterChain = new TagFilterChain;
		$filter = new TagFilter('strtolower');

		$this->assertSame(
			$filter,
			$filterChain->append($filter)
		);
	}

	/**
	* @testdox containsCallback('akmaljp\\DriveMaru\\Parser\\FilterProcessing::filterAttributes') returns true on default tags
	*/
	public function testContainsCallback()
	{
		$tag = new Tag;
		$this->assertTrue($tag->filterChain->containsCallback('akmaljp\\DriveMaru\\Parser\\FilterProcessing::filterAttributes'));
	}

	/**
	* @testdox containsCallback('akmaljp\\DriveMaru\\Parser\\FilterProcessing::filterAttributes') returns false on empty chains
	*/
	public function testContainsCallbackFalse()
	{
		$filterChain = new TagFilterChain;
		$this->assertFalse($filterChain->containsCallback('akmaljp\\DriveMaru\\Parser\\FilterProcessing::filterAttributes'));
	}

}