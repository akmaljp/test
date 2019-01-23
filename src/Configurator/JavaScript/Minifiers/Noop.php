<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\JavaScript\Minifiers;

use akmaljp\DriveMaru\Configurator\JavaScript\Minifier;

/**
* No-op minifier
*/
class Noop extends Minifier
{
	/**
	* No-op method, output is the same as input
	*
	* @param  string $src JavaScript source
	* @return string      The very same JavaScript source
	*/
	public function minify($src)
	{
		return $src;
	}
}