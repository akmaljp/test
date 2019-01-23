<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Bundles;

use DOMDocument;
use akmaljp\DriveMaru\Configurator;
use akmaljp\DriveMaru\Configurator\Bundle;

class MediaPack extends Bundle
{
	/**
	* {@inheritdoc}
	*/
	public function configure(Configurator $configurator)
	{
		if (!isset($configurator->MediaEmbed))
		{
			// Only create BBCodes if the BBCodes plugin is already loaded
			$pluginOptions = ['createMediaBBCode' => isset($configurator->BBCodes)];

			$configurator->plugins->load('MediaEmbed', $pluginOptions);
		}

		foreach ($configurator->MediaEmbed->defaultSites as $siteId => $siteConfig)
		{
			$configurator->MediaEmbed->add($siteId);
		}
	}
}