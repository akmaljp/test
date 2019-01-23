<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\JavaScript;

use ArrayObject;
use akmaljp\DriveMaru\Configurator\FilterableConfigValue;
use akmaljp\DriveMaru\Configurator\Helpers\ConfigHelper;

/**
* This class's sole purpose is to identify arrays that need their keys to be preserved in JavaScript
*/
class Dictionary extends ArrayObject implements FilterableConfigValue
{
	/**
	* {@inheritdoc}
	*/
	public function filterConfig($target)
	{
		$value = $this->getArrayCopy();
		if ($target === 'JS')
		{
			$value = new Dictionary(ConfigHelper::filterConfig($value, $target));
		}

		return $value;
	}
}