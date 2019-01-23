<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Parser\AttributeFilters;

class MapFilter
{
	/**
	* Filter a mapped value
	*
	* NOTE: if there's no match, the original value is returned
	*
	* @param  string $attrValue Original value
	* @param  array  $map       List in the form [[<regexp>, <value>]]
	* @return mixed             Filtered value, or FALSE if invalid
	*/
	public static function filter($attrValue, array $map)
	{
		foreach ($map as $pair)
		{
			if (preg_match($pair[0], $attrValue))
			{
				return $pair[1];
			}
		}

		return $attrValue;
	}
}