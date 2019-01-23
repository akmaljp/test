<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator;

interface RendererGenerator
{
	/**
	* Generate and return a renderer
	*
	* @param  Rendering                   $rendering Rendering configuration
	* @return \akmaljp\DriveMaru\Renderer            Instance of Renderer
	*/
	public function getRenderer(Rendering $rendering);
}