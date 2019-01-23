<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\Validators\TemplateParameterName;

class TemplateParameterCollection extends NormalizedCollection
{
	/**
	* Normalize a parameter name
	*
	* @param  string $key
	* @return string
	*/
	public function normalizeKey($key)
	{
		return TemplateParameterName::normalize($key);
	}

	/**
	* Normalize a parameter value
	*
	* @param  mixed  $value
	* @return string
	*/
	public function normalizeValue($value)
	{
		return (string) $value;
	}
}