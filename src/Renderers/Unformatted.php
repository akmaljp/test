<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Renderers;

use akmaljp\DriveMaru\Renderer;

/**
* This renderer returns a plain text version of rich text. It is meant to be used as a last resort
* when every other renderer is unavailable
*/
class Unformatted extends Renderer
{
	/**
	* {@inheritdoc}
	*/
	protected function renderRichText($xml)
	{
		return str_replace("\n", "<br>\n", htmlspecialchars(strip_tags($xml), ENT_COMPAT, 'UTF-8', false));
	}
}