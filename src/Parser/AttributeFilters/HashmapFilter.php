<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Parser\AttributeFilters;

class HashmapFilter
{
	/**
	* Filter a value through a hash map
	*
	* @param  string $attrValue Original value
	* @param  array  $map       Associative array
	* @param  bool   $strict    Whether this map is strict (values with no match are invalid)
	* @return mixed             Filtered value, or FALSE if invalid
	*/
	public static function filter($attrValue, array $map, $strict)
	{
		if (isset($map[$attrValue]))
		{
			return $map[$attrValue];
		}

		return ($strict) ? false : $attrValue;
	}
}