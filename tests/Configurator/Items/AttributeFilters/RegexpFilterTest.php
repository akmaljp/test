<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Helpers\ConfigHelper;
use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\RegexpFilter;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\AttributeFilters\RegexpFilter
*/
class RegexpFilterTest extends Test
{
	/**
	* @testdox Callback is akmaljp\DriveMaru\Parser\AttributeFilters\RegexpFilter::filter()
	*/
	public function testCallback()
	{
		$filter = new RegexpFilter;

		$this->assertSame(
			'akmaljp\\DriveMaru\\Parser\\AttributeFilters\\RegexpFilter::filter',
			$filter->getCallback()
		);
	}

	/**
	* @testdox Is not safe as URL
	*/
	public function testURLUnsafeNoRegexp()
	{
		$filter = new RegexpFilter;

		$this->assertFalse($filter->isSafeAsURL());
	}

	/**
	* @testdox Is safe as URL if the regexp is /^[a-z]$/
	*/
	public function testURLSafeAlpha()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/^[a-z]$/');

		$this->assertTrue($filter->isSafeAsURL());
	}

	/**
	* @testdox Is safe as URL if the regexp is /^foo:(.*)/
	*/
	public function testURLSafeFixedScheme()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/^foo:(.*)/');

		$this->assertTrue($filter->isSafeAsURL());
	}

	/**
	* @testdox Is not safe as URL if the regexp is /^foo:(.*)/m
	*/
	public function testURLUnsafeFixedSchemeMultiline()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/^foo:(.*)/m');

		$this->assertFalse($filter->isSafeAsURL());
	}

	/**
	* @testdox Is safe as URL if the regexp is /^https?:(.*)/
	*/
	public function testURLSafeFixedSchemeWithJoker()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/^https?:(.*)/');

		$this->assertTrue($filter->isSafeAsURL());
	}

	/**
	* @testdox Is safe as URL if the regexp is /^(https?:.*)/
	*/
	public function testURLSafeCapturedFixedSchemeWithJoker()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/^(https?:.*)/');

		$this->assertTrue($filter->isSafeAsURL());
	}

	/**
	* @testdox Is safe as URL if the regexp is /^(?:https?:.*)/
	*/
	public function testURLSafeNonCapturingFixedSchemeWithJoker()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/^(?:https?:.*)/');

		$this->assertTrue($filter->isSafeAsURL());
	}

	/**
	* @testdox Is not safe as URL if the regexp is /^javascript:(.*)/
	*/
	public function testURLUnsafeJavaScriptScheme()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/^javascript:(.*)/');

		$this->assertFalse($filter->isSafeAsURL());
	}

	/**
	* @testdox Is not safe as URL if the regexp is /^javascriptx?:(.*)/
	*/
	public function testURLUnsafeJavaScriptSchemeWithJoker()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/^javascriptx?:(.*)/');

		$this->assertFalse($filter->isSafeAsURL());
	}

	/**
	* @testdox Is not safe as URL if the regexp allows a colon to be used
	*/
	public function testURLUnsafeColon()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/^:$/');

		$this->assertFalse($filter->isSafeAsURL());
	}

	/**
	* @testdox Is not safe as URL if the regexp is invalid
	*/
	public function testURLUnsafeInvalidRegexp()
	{
		$filter = new RegexpFilter;
		$filter->setVars(['regexp' => ')invalid(']);

		$this->assertFalse($filter->isSafeAsURL());
	}

	/**
	* @testdox Is not safe as URL if the regexp can't be parsed
	*/
	public function testURLUnsafeCannotParse()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/^(?|x|y)$/');

		$this->assertFalse($filter->isSafeAsURL());
	}

	/**
	* @testdox Is safe in CSS if the regexp is /^(?:left|right|center)$/
	*/
	public function testCSSSafe()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/^(?:left|right|center)$/');

		$this->assertTrue($filter->isSafeInCSS());
	}

	/**
	* @testdox Is safe in CSS if the regexp is /^[a-z]$/
	*/
	public function testCSSSafeAlpha()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/^[a-z]$/');

		$this->assertTrue($filter->isSafeInCSS());
	}

	/**
	* @testdox Is not safe in CSS if the regexp is /^[A-z]$/ because it would allow backslashes
	*/
	public function testCSSUnsafeCharacterClass()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/^[A-z]$/');

		$this->assertFalse($filter->isSafeInCSS());
	}

	/**
	* @testdox Is not safe in CSS if the regexp is invalid
	*/
	public function testCSSUnsafeInvalidRegexp()
	{
		$filter = new RegexpFilter;
		$filter->setVars(['regexp' => ')invalid(']);

		$this->assertFalse($filter->isSafeInCSS());
	}

	/**
	* @testdox Is not safe in CSS if no regexp is set
	*/
	public function testCSSUnsafeNoRegexp()
	{
		$filter = new RegexpFilter;

		$this->assertFalse($filter->isSafeInCSS());
	}

	/**
	* @testdox Is safe in JS if the regexp is /^\d+$/D
	*/
	public function testJSSafe1()
	{
		$filter = new RegexpFilter('/^\\d+$/D');

		$this->assertTrue($filter->isSafeInJS());
	}

	/**
	* @testdox Is safe in JS if the regexp is /^[0-9]+$/D
	*/
	public function testJSSafe2()
	{
		$filter = new RegexpFilter('/^[0-9]+$/D');

		$this->assertTrue($filter->isSafeInJS());
	}

	/**
	* @testdox Is safe in JS if the regexp is /^(?:[0-9]+)$/D
	*/
	public function testJSSafe3()
	{
		$filter = new RegexpFilter('/^(?:[0-9]+)$/D');

		$this->assertTrue($filter->isSafeInJS());
	}

	/**
	* @testdox Is not safe in JS if the regexp is /^\d+/D
	*/
	public function testJSUnsafeUnanchoredStart()
	{
		$filter = new RegexpFilter('/^\\d+/D');

		$this->assertFalse($filter->isSafeInJS());
	}

	/**
	* @testdox Is not safe in JS if the regexp is /\d+$/D
	*/
	public function testJSUnsafeUnanchoredEnd()
	{
		$filter = new RegexpFilter('/\\d+$/D');

		$this->assertFalse($filter->isSafeInJS());
	}

	/**
	* @testdox Is not safe in JS if the regexp is /^\d+$/
	*/
	public function testJSUnsafeNoDollarEndOnly()
	{
		$filter = new RegexpFilter('/^\\d+$/');

		$this->assertFalse($filter->isSafeInJS());
	}

	/**
	* @testdox Is not safe in JS if the regexp is /^\d+$/Dm
	*/
	public function testJSUnsafeMultiLine()
	{
		$filter = new RegexpFilter('/^\\d+$/Dm');

		$this->assertFalse($filter->isSafeInJS());
	}

	/**
	* @testdox __construct() forwards its arguments to setRegexp()
	*/
	public function testConstructorArguments()
	{
		$className = 'akmaljp\\DriveMaru\\Configurator\\Items\\AttributeFilters\\RegexpFilter';
		$filter = $this->getMockBuilder($className)
		               ->disableOriginalConstructor()
		               ->getMock();

		$filter->expects($this->once())
		       ->method('setRegexp')
		       ->with('/foo/');

		$filter->__construct('/foo/');
	}

	/**
	* @testdox getRegexp() returns the filter's regexp
	*/
	public function testGetRegexp()
	{
		$filter = new RegexpFilter('/foo/');

		$this->assertSame('/foo/', $filter->getRegexp());
	}

	/**
	* @testdox setRegexp() sets the filter's regexp
	*/
	public function testSetRegexp()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/x/');

		$this->assertEquals(
			['regexp' => '/x/'],
			$filter->getVars()
		);
	}

	/**
	* @testdox setRegexp() throws an exception if the regexp is invalid
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Invalid regular expression '???'
	*/
	public function testSetRegexpInvalid()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('???');
	}

	/**
	* @testdox asConfig() returns an array
	*/
	public function testAsConfig()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/x/');

		$this->assertInternalType('array', $filter->asConfig());
	}

	/**
	* @testdox asConfig() throws an exception if the 'regexp' var is missing
	* @expectedException RuntimeException
	* @expectedExceptionMessage Regexp filter is missing a 'regexp' value
	*/
	public function testMissingRegexp()
	{
		$filter = new RegexpFilter;
		$filter->asConfig();
	}

	/**
	* @testdox asConfig() creates a Regexp instance
	*/
	public function testAsConfigRegexp()
	{
		$filter = new RegexpFilter;
		$filter->setRegexp('/x/');

		$config = $filter->asConfig();

		$slice  = array_slice($config['params'], 1, 1);
		$variant = end($slice);

		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Items\\Regexp',
			$variant
		);
	}

	/**
	* @testdox Changing the regexp resets the filter's safeness
	*/
	public function testSetRegexpResetsSafeness()
	{
		$filter = new RegexpFilter('/^[0-9]+$/D');
		$this->assertTrue($filter->isSafeInJS());

		$filter->setRegexp('//');
		$this->assertFalse($filter->isSafeInJS());

		$filter->setRegexp('/^\\d+$/D');
		$this->assertTrue($filter->isSafeInJS());
	}

	/**
	* @testdox Template safeness can be set manually
	*/
	public function testMarkAsSafe()
	{
		$filter = new RegexpFilter('/^(?:0|1\\d*)$/');
		$this->assertFalse($filter->isSafeInJS());
		$filter->markAsSafeInJS();
		$this->assertTrue($filter->isSafeInJS());
	}
}