<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Validators;

use InvalidArgumentException;

/**
* Tag name rules:
*  - must start with a letter or an underscore
*  - can only contain letters, numbers, dashes and underscores
*  - can be prefixed with one prefix following the same rules, separated with one colon
*  - the prefixes "xsl" and "akmaljp" are reserved
*
* Unprefixed names are normalized to uppercase. Prefixed names are preserved as-is.
*/
abstract class TagName
{
	/**
	* Return whether a string is a valid tag name
	*
	* @param  string $name
	* @return bool
	*/
	public static function isValid($name)
	{
		return (bool) preg_match('#^(?:(?!xmlns|xsl|akmaljp)[a-z_][a-z_0-9]*:)?[a-z_][-a-z_0-9]*$#Di', $name);
	}

	/**
	* Normalize a tag name
	*
	* @throws InvalidArgumentException if the original name is not valid
	*
	* @param  string $name Original name
	* @return string       Normalized name
	*/
	public static function normalize($name)
	{
		if (!static::isValid($name))
		{
			throw new InvalidArgumentException("Invalid tag name '" . $name . "'");
		}

		// Non-namespaced tags are uppercased
		if (strpos($name, ':') === false)
		{
			$name = strtoupper($name);
		}

		return $name;
	}
}