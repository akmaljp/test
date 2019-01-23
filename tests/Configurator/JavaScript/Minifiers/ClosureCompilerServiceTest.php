<?php

namespace akmaljp\DriveMaru\Tests\Configurator\JavaScript\Minifiers;

use RuntimeException;
use akmaljp\DriveMaru\Utils\Http\Client;
use akmaljp\DriveMaru\Configurator\JavaScript\Minifiers\ClosureCompilerService;
use akmaljp\DriveMaru\Tests\Test;

/**
* @requires extension json
* @covers akmaljp\DriveMaru\Configurator\JavaScript\OnlineMinifier
* @covers akmaljp\DriveMaru\Configurator\JavaScript\Minifiers\ClosureCompilerService
*/
class ClosureCompilerServiceTest extends Test
{
	/**
	* @testdox Works
	* @group needs-network
	*/
	public function testBasic()
	{
		$original =
			"function hello(name) {
				alert('Hello, ' + name);
			}
			hello('New user')";

		$expected = 'alert("Hello, New user");';

		$minifier = new ClosureCompilerService;
		try
		{
			$this->assertSame($expected, $minifier->minify($original));
		}
		catch (RuntimeException $e)
		{
			if (strpos($e->getMessage(), 'Too many compiles performed recently') === false)
			{
				throw $e;
			}
			$this->markTestSkipped($e->getMessage());
		}
	}

	/**
	* @testdox Compilation level is ADVANCED_OPTIMIZATIONS by default
	*/
	public function testCompilationLevelDefault()
	{
		$minifier = new ClosureCompilerService;
		$minifier->httpClient = new ClosureCompilerServiceTestClient;
		$minifier->minify('');

		$this->assertContains(
			'compilation_level=ADVANCED_OPTIMIZATIONS',
			$minifier->httpClient->body
		);
	}

	/**
	* @testdox Excludes default externs by default
	*/
	public function testExcludesDefaultExternsByDefault()
	{
		$minifier = new ClosureCompilerService;
		$minifier->httpClient = new ClosureCompilerServiceTestClient;
		$minifier->minify('');

		$this->assertContains(
			'exclude_default_externs=true',
			$minifier->httpClient->body
		);
	}

	/**
	* @testdox Includes our custom externs by default
	*/
	public function testCustomExterns()
	{
		$externs = file_get_contents(__DIR__ . '/../../../../src/Configurator/JavaScript/externs.service.js');

		$minifier = new ClosureCompilerService;
		$minifier->httpClient = new ClosureCompilerServiceTestClient;
		$minifier->minify('');

		$this->assertContains(
			'js_externs=' . urlencode($externs),
			$minifier->httpClient->body
		);
	}

	/**
	* @testdox Allows caching
	*/
	public function testAllowsCaching()
	{
		$minifier = new ClosureCompilerService;

		$this->assertNotSame(false, $minifier->getCacheDifferentiator());
	}

	/**
	* @testdox The cache key depends on the compilation level
	*/
	public function testCacheKeyCompilationLevel()
	{
		$minifier = new ClosureCompilerService;

		$minifier->compilationLevel = 'ADVANCED_OPTIMIZATIONS';
		$k1 = $minifier->getCacheDifferentiator();

		$minifier->compilationLevel = 'SIMPLE_OPTIMIZATIONS';
		$k2 = $minifier->getCacheDifferentiator();

		$this->assertNotEquals($k1, $k2);
	}

	/**
	* @testdox The cache key depends on whether the default externs are excluded
	*/
	public function testCacheKeyDefaultExterns()
	{
		$minifier = new ClosureCompilerService;

		$minifier->excludeDefaultExterns = true;
		$k1 = $minifier->getCacheDifferentiator();

		$minifier->excludeDefaultExterns = false;
		$k2 = $minifier->getCacheDifferentiator();

		$this->assertNotEquals($k1, $k2);
	}

	/**
	* @testdox If the default externs are excluded, the custom externs are baked into the cache key
	*/
	public function testCacheKeyCustomExterns()
	{
		$minifier = new ClosureCompilerService;
		$minifier->excludeDefaultExterns = true;

		$this->assertTrue(in_array($minifier->externs, $minifier->getCacheDifferentiator(), true));
	}

	/**
	* @testdox Throws an exception in case of a request failure
	* @expectedException RuntimeException
	* @expectedExceptionMessage Could not contact the Closure Compiler service
	*/
	public function testRequestFailure()
	{
		$minifier = new ClosureCompilerService;
		$minifier->httpClient = new ClosureCompilerServiceTestClient;
		$minifier->httpClient->willReturn = false;
		$minifier->minify('');
	}

	/**
	* @testdox Throws an exception if the response isn't valid JSON
	* @expectedException RuntimeException
	* @expectedExceptionMessage Closure Compiler service returned invalid JSON: Syntax error
	*/
	public function testJSONError()
	{
		$minifier = new ClosureCompilerService;
		$minifier->httpClient = new ClosureCompilerServiceTestClient;
		$minifier->httpClient->willReturn = 'not JSON';
		$minifier->minify('');
	}

	/**
	* @testdox Throws an exception in case of a server error
	* @expectedException RuntimeException
	* @expectedExceptionMessage Server error 4: Unknown compression level: UNKNOWN
	*/
	public function testServerError()
	{
		$minifier = new ClosureCompilerService;
		$minifier->compilationLevel = 'UNKNOWN';
		$minifier->httpClient = new ClosureCompilerServiceTestClient;
		$minifier->httpClient->willReturn = '{"serverErrors":[{"code":4,"error":"Unknown compression level: UNKNOWN."}]}';

		$minifier->minify('alert()');
	}

	/**
	* @testdox Throws an exception in case of a compilation error
	* @expectedException RuntimeException
	* @expectedExceptionMessage Parse error. Semi-colon expected
	*/
	public function testCompilationError()
	{
		$minifier = new ClosureCompilerService;
		$minifier->httpClient = new ClosureCompilerServiceTestClient;
		$minifier->httpClient->willReturn = '{"compiledCode":"","errors":[{"type":"JSC_PARSE_ERROR","file":"Input_0","lineno":1,"charno":5,"error":"Parse error. Semi-colon expected","line":"This should fail"}]}';

		$minifier->minify('This should fail');
	}
}

class ClosureCompilerServiceTestClient extends Client
{
	public $body;
	public $headers;
	public $url;
	public $willReturn = '{"compiledCode":""}';

	public function get($url, $headers = [])
	{
		$this->url     = $url;
		$this->headers = $headers;

		return $this->willReturn;
	}

	public function post($url, $headers = [], $body = '')
	{
		$this->url     = $url;
		$this->headers = $headers;
		$this->body    = $body;

		return $this->willReturn;
	}
}