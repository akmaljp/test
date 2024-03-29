<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator;

use akmaljp\DriveMaru\Configurator;

abstract class Bundle
{
	/**
	* Configure a Configurator instance with this bundle's settings
	*
	* @param  Configurator $configurator
	* @return void
	*/
	abstract public function configure(Configurator $configurator);

	/**
	* Create and return a configured instance of Configurator
	*
	* @return Configurator
	*/
	public static function getConfigurator()
	{
		$configurator = new Configurator;

		$bundle  = new static;
		$bundle->configure($configurator);

		return $configurator;
	}

	/**
	* Return extra options to be passed to the bundle generator
	*
	* Used by scripts/generateBundles.php
	*
	* @return array
	*/
	public static function getOptions()
	{
		return [];
	}
}