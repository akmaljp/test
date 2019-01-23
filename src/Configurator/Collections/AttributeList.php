<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\Validators\AttributeName;

/**
* Hosts a list of attribute names. The config array it returns contains the names, deduplicated and
* sorted
*/
class AttributeList extends NormalizedList
{
	/**
	* Normalize the name of an attribute
	*
	* @param  string $attrName
	* @return string
	*/
	public function normalizeValue($attrName)
	{
		return AttributeName::normalize($attrName);
	}

	/**
	* {@inheritdoc}
	*/
	public function asConfig()
	{
		$list = array_unique($this->items);
		sort($list);

		return $list;
	}
}