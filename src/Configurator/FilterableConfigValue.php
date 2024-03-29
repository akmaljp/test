<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator;

interface FilterableConfigValue
{
	/**
	* Return the config value for given target
	*
	* @param  $target
	* @return mixed
	*/
	public function filterConfig($target);
}