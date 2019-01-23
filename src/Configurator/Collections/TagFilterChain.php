<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Collections;

class TagFilterChain extends FilterChain
{
	/**
	* {@inheritdoc}
	*/
	public function getFilterClassName()
	{
		return 'akmaljp\\DriveMaru\\Configurator\\Items\\TagFilter';
	}
}