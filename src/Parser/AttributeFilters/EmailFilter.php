<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Parser\AttributeFilters;

class EmailFilter
{
	/**
	* Filter an email value
	*
	* @param  string $attrValue Original value
	* @return mixed             Filtered value, or FALSE if invalid
	*/
	public static function filter($attrValue)
	{
		return filter_var($attrValue, FILTER_VALIDATE_EMAIL);
	}
}