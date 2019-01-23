<?php

namespace akmaljp\DriveMaru\Tests\Configurator;

use akmaljp\DriveMaru\Configurator\JavaScript\Code;
use akmaljp\DriveMaru\Configurator\JavaScript\CallbackGenerator;
use akmaljp\DriveMaru\Tests\Test;

/**
* @requires extension json
* @covers akmaljp\DriveMaru\Configurator\JavaScript\CallbackGenerator
*/
class CallbackGeneratorTest extends Test
{
	/**
	* @testdox replaceCallbacks() tests
	* @dataProvider getReplaceCallbacksTests
	*/
	public function testReplaceCallbacks($original, $expected)
	{
		$generator = new CallbackGenerator;
		$this->assertEquals($expected, $generator->replaceCallbacks($original));
	}

	public function getReplaceCallbacksTests()
	{
		return [
			[
				[],
				[]
			],
			[
				[
					'tags' => [
						'X' => [
							'filterChain' => [
								[
									'js' => 'executeAttributePreprocessors',
									'params' => [
										'tag' => null,
										'tagConfig' => null
									]
								]
							]
						]
					]
				],
				[
					'tags' => [
						'X' => [
							'filterChain' => [
								new Code("/**\n* @param {!Tag} tag\n* @param {!Object} tagConfig\n*/\nfunction(tag,tagConfig){return executeAttributePreprocessors(tag,tagConfig);}")
							]
						]
					]
				]
			],
			[
				[
					'tags' => [
						'X' => [
							'attributes' => [
								'x' => [
									'filterChain' => [
										[
											'js' => 'function(z){return z}',
											'params' => ['FOO']
										]
									]
								]
							]
						]
					]
				],
				[
					'tags' => [
						'X' => [
							'attributes' => [
								'x' => [
									'filterChain' => [
										new Code("/**\n* @param {*} attrValue\n* @param {!string} attrName\n*/\nfunction(attrValue,attrName){return (function(z){return z})(\"FOO\");}")
									]
								]
							]
						]
					]
				]
			],
			[
				[
					'tags' => [
						'X' => [
							'filterChain' => [
								[
									'js' => 'function(v){return v}',
									'params' => [
										'registered' => null
									]
								]
							]
						]
					]
				],
				[
					'tags' => [
						'X' => [
							'filterChain' => [
								new Code("/**\n* @param {!Tag} tag\n* @param {!Object} tagConfig\n*/\nfunction(tag,tagConfig){return (function(v){return v})(registeredVars[\"registered\"]);}")
							]
						]
					]
				]
			],
			[
				[
					'tags' => [
						'X' => ['filterChain' => [['js' => 'returnFalse']]]
					]
				],
				[
					'tags' => [
						'X' => ['filterChain' => [new Code('returnFalse')]]
					]
				]
			],
			[
				[
					'tags' => [
						'X' => ['filterChain' => [['js' => 'returnTrue']]]
					]
				],
				[
					'tags' => [
						'X' => ['filterChain' => [new Code('returnTrue')]]
					]
				]
			],
		];
	}
}