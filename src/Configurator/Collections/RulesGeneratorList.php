<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Collections;

use InvalidArgumentException;
use akmaljp\DriveMaru\Configurator\RulesGenerators\Interfaces\BooleanRulesGenerator;
use akmaljp\DriveMaru\Configurator\RulesGenerators\Interfaces\TargetedRulesGenerator;

class RulesGeneratorList extends NormalizedList
{
	/**
	* Normalize the value to an object
	*
	* @param  string|BooleanRulesGenerator|TargetedRulesGenerator $generator Either a string, or an instance of a rules generator
	* @return BooleanRulesGenerator|TargetedRulesGenerator
	*/
	public function normalizeValue($generator)
	{
		if (is_string($generator))
		{
			$className = 'akmaljp\\DriveMaru\\Configurator\\RulesGenerators\\' . $generator;

			if (class_exists($className))
			{
				$generator = new $className;
			}
		}

		if (!($generator instanceof BooleanRulesGenerator)
		 && !($generator instanceof TargetedRulesGenerator))
		{
			throw new InvalidArgumentException('Invalid rules generator ' . var_export($generator, true));
		}

		return $generator;
	}
}