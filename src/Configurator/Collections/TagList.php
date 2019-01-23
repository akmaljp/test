<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\Validators\TagName;

/**
* Hosts a list of tag names. The config array it returns contains the names, deduplicated and sorted
*/
class TagList extends NormalizedList
{
	/**
	* Normalize a value to a tag name
	*
	* @param  string $attrName
	* @return string
	*/
	public function normalizeValue($attrName)
	{
		return TagName::normalize($attrName);
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