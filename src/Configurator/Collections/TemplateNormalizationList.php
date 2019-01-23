<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\TemplateNormalizations\AbstractNormalization;
use akmaljp\DriveMaru\Configurator\TemplateNormalizations\Custom;

class TemplateNormalizationList extends NormalizedList
{
	/**
	* Normalize the value to an instance of AbstractNormalization
	*
	* @param  mixed                 $value Either a string, or an instance of AbstractNormalization
	* @return AbstractNormalization        An instance of AbstractNormalization
	*/
	public function normalizeValue($value)
	{
		if ($value instanceof AbstractNormalization)
		{
			return $value;
		}

		if (is_callable($value))
		{
			return new Custom($value);
		}

		$className = 'akmaljp\\DriveMaru\\Configurator\\TemplateNormalizations\\' . $value;

		return new $className;
	}
}