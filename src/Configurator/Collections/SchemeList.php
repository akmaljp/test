<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Collections;

use InvalidArgumentException;
use akmaljp\DriveMaru\Configurator\Helpers\RegexpBuilder;
use akmaljp\DriveMaru\Configurator\Items\Regexp;

class SchemeList extends NormalizedList
{
	/**
	* Return this scheme list as a regexp
	*
	* @return Regexp
	*/
	public function asConfig()
	{
		return new Regexp('/^' . RegexpBuilder::fromList($this->items) . '$/Di');
	}

	/**
	* Validate and normalize a scheme name to lowercase, or throw an exception if invalid
	*
	* @link http://tools.ietf.org/html/rfc3986#section-3.1
	*
	* @param  string $scheme URL scheme, e.g. "file" or "ed2k"
	* @return string
	*/
	public function normalizeValue($scheme)
	{
		if (!preg_match('#^[a-z][a-z0-9+\\-.]*$#Di', $scheme))
		{
			throw new InvalidArgumentException("Invalid scheme name '" . $scheme . "'");
		}

		return strtolower($scheme);
	}
}