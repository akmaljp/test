<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Collections;

use InvalidArgumentException;
use ReflectionClass;
use akmaljp\DriveMaru\Configurator\JavaScript\Minifier;

class MinifierList extends NormalizedList
{
	/**
	* Normalize the value to an object
	*
	* @param  Minifier|string $minifier
	* @return Minifier
	*/
	public function normalizeValue($minifier)
	{
		if (is_string($minifier))
		{
			$minifier = $this->getMinifierInstance($minifier);
		}
		elseif (is_array($minifier) && !empty($minifier[0]))
		{
			$minifier = $this->getMinifierInstance($minifier[0], array_slice($minifier, 1));
		}

		if (!($minifier instanceof Minifier))
		{
			throw new InvalidArgumentException('Invalid minifier ' . var_export($minifier, true));
		}

		return $minifier;
	}

	/**
	* Create and return a Minifier instance
	*
	* @param  string   Minifier's name
	* @param  array    Constructor's arguments
	* @return Minifier
	*/
	protected function getMinifierInstance($name, array $args = [])
	{
		$className = 'akmaljp\\DriveMaru\\Configurator\\JavaScript\\Minifiers\\' . $name;
		if (!class_exists($className))
		{
			throw new InvalidArgumentException('Invalid minifier ' . var_export($name, true));
		}

		$reflection = new ReflectionClass($className);
		$minifier   = (empty($args)) ? $reflection->newInstance() : $reflection->newInstanceArgs($args);

		return $minifier;
	}
}