<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\JavaScript\Minifiers;

use MatthiasMullie\Minify;
use akmaljp\DriveMaru\Configurator\JavaScript\Minifier;

/**
* @link http://www.minifier.org/
*/
class MatthiasMullieMinify extends Minifier
{
	/**
	* Compile given JavaScript source using matthiasmullie/minify
	*
	* @param  string $src JavaScript source
	* @return string      Compiled source
	*/
	public function minify($src)
	{
		$minifier = new Minify\JS($src);

		return $minifier->minify();
	}
}