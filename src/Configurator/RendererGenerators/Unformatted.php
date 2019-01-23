<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\RendererGenerators;

use akmaljp\DriveMaru\Configurator\RendererGenerator;
use akmaljp\DriveMaru\Configurator\Rendering;
use akmaljp\DriveMaru\Renderers\Unformatted as UnformattedRenderer;

class Unformatted implements RendererGenerator
{
	/**
	* {@inheritdoc}
	*/
	public function getRenderer(Rendering $rendering)
	{
		return new UnformattedRenderer;
	}
}