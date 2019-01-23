<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator;

interface ConfigProvider
{
	/**
	* Return an array-based representation of this object to be used for parsing
	*
	* NOTE: if this method was named getConfig() it could interfere with magic getters from
	*       the Configurable trait
	*
	* @return array|\akmaljp\DriveMaru\Configurator\JavaScript\Dictionary|null
	*/
	public function asConfig();
}