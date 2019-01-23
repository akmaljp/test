<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Parser\AttributeFilters;

class FalseFilter
{
	/**
	* Invalidate an attribute value
	*
	* @param  string $attrValue Original value
	* @return bool              Always FALSE
	*/
	public static function filter($attrValue)
	{
		return false;
	}
}