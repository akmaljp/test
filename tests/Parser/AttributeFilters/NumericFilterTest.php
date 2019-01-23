<?php

namespace akmaljp\DriveMaru\Tests\Parser\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\FloatFilter;
use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\IntFilter;
use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\NumberFilter;
use akmaljp\DriveMaru\Configurator\Items\AttributeFilters\UintFilter;
use akmaljp\DriveMaru\Parser\AttributeFilters\NumericFilter;

/**
* @covers akmaljp\DriveMaru\Parser\AttributeFilters\NumericFilter
*/
class NumericFilterTest extends AbstractFilterTest
{
	/**
	* @dataProvider getRegressionsData
	* @testdox Regression tests
	*/
	public function testRegressions($original, array $results)
	{
		foreach ($results as $filterName => $expected)
		{
			$methodName = 'filter' . ucfirst($filterName);
			$this->assertSame($expected, NumericFilter::$methodName($original));
		}
	}

	/**
	* NOTE: this test is not normative. Some cases exist solely to track regressions or changes in
	*       behaviour in ext/filter
	*/
	public function getRegressionsData()
	{
		return [
			['123',    ['int' => 123,   'uint' => 123,   'float' => 123.0]],
			['123abc', ['int' => false, 'uint' => false, 'float' => false]],
			['0123',   ['int' => false, 'uint' => false, 'float' => 123.0]],
			['-123',   ['int' => -123,  'uint' => false, 'float' => -123.0]],
			['12.3',   ['int' => false, 'uint' => false, 'float' => 12.3]],
			['10000000000000000000', ['int' => false, 'uint' => false, 'float' => 10000000000000000000]],
			['12e3',   ['int' => false, 'uint' => false, 'float' => 12000.0]],
			['-12e3',  ['int' => false, 'uint' => false, 'float' => -12000.0]],
			['12e-3',  ['int' => false, 'uint' => false, 'float' => 0.012]],
			['-12e-3', ['int' => false, 'uint' => false, 'float' => -0.012]],
			['0x123',  ['int' => false, 'uint' => false, 'float' => false]],
		];
	}

	public function getFilterTests()
	{
		return [
			[new FloatFilter,  '123',     123  ],
			[new FloatFilter,  '123.1',   123.1],
			[new FloatFilter,  '123.1.2', false],
			[new IntFilter,    '0',       0    ],
			[new IntFilter,    '123',     123  ],
			[new IntFilter,    '-123',    -123 ],
			[new IntFilter,    '123.1',   false],
			[new NumberFilter, '0',       0    ],
			[new NumberFilter, '123',     123  ],
			[new NumberFilter, '012',     '012'],
			[new NumberFilter, '123x',    false],
			[new UintFilter,   '0',       0    ],
			[new UintFilter,   '123',     123  ],
			[new UintFilter,   '-123',    false],
			[new UintFilter,   '123.1',   false],
		];
	}
}