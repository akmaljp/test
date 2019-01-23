<?php

namespace akmaljp\DriveMaru\Tests\Configurator;

use akmaljp\DriveMaru\Configurator\JavaScript\ConfigOptimizer;
use akmaljp\DriveMaru\Configurator\JavaScript\Code;
use akmaljp\DriveMaru\Configurator\JavaScript\Dictionary;
use akmaljp\DriveMaru\Configurator\JavaScript\Encoder;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\JavaScript\ConfigOptimizer
*/
class ConfigOptimizerTest extends Test
{
	/**
	* @testdox reset() clears the stored objects
	*/
	public function testReset()
	{
		$optimizer = new ConfigOptimizer(new Encoder);
		$optimizer->optimize([['xyz'],['xyz']]);
		$this->assertNotEmpty($optimizer->getVarDeclarations());
		$optimizer->reset();
		$this->assertEmpty($optimizer->getVarDeclarations());
	}

	/**
	* @testdox OptimizeObject tests
	* @dataProvider getOptimizeObjectTests
	*/
	public function testOptimizeObject($original, $expected, $objects)
	{
		$encoder   = new Encoder;
		$optimizer = new ConfigOptimizer($encoder);
		$config    = $optimizer->optimize($original);

		$this->assertSame($expected, $encoder->encode($config));
		$this->assertSame(implode("\n", $objects), rtrim($optimizer->getVarDeclarations()));
	}

	public function getOptimizeObjectTests()
	{
		return [
			[
				[
					'foo' => [12345, 54321],
					'bar' => [12345, 54321]
				],
				'{bar:o3D7424E0,foo:o3D7424E0}',
				[
					'/** @const */ var o3D7424E0=[12345,54321];'
				]
			],
			[
				new Dictionary([
					'foo' => [12345, 54321],
					'bar' => [12345, 54321]
				]),
				'{"bar":o3D7424E0,"foo":o3D7424E0}',
				[
					'/** @const */ var o3D7424E0=[12345,54321];'
				]
			],
			[
				[
					'foo' => [12345],
					'bar' => [54321, 12345]
				],
				'{bar:[54321,12345],foo:[12345]}',
				[]
			],
			[
				[
					'foo' => [new Code('function(){return false;}')],
					'bar' => [new Code('function(){return false;}')]
				],
				'{bar:oBDF6D802,foo:oBDF6D802}',
				[
					'/** @const */ var oBDF6D802=[function(){return false;}];'
				]
			],
			[
				// Test that returnFalse is stored as-is. No need for a config value
				[
					'foo' => new Code('returnFalse'),
					'bar' => new Code('returnFalse')
				],
				'{bar:returnFalse,foo:returnFalse}',
				[]
			],
			[
				[
					'foo' => [],
					'bar' => []
				],
				'{bar:[],foo:[]}',
				[]
			],
			[
				[
					'foo' => new Dictionary,
					'bar' => new Dictionary
				],
				'{bar:{},foo:{}}',
				[]
			],
		];
	}
}