<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\TemplateChecks;

use DOMElement;
use akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException;
use akmaljp\DriveMaru\Configurator\Items\Tag;
use akmaljp\DriveMaru\Configurator\TemplateCheck;

class DisallowDynamicElementNames extends TemplateCheck
{
	/**
	* Test for the presence of an <xsl:element/> node using a dynamic name
	*
	* @param  DOMElement $template <xsl:template/> node
	* @param  Tag        $tag      Tag this template belongs to
	* @return void
	*/
	public function check(DOMElement $template, Tag $tag)
	{
		$nodes = $template->getElementsByTagNameNS(self::XMLNS_XSL, 'element');
		foreach ($nodes as $node)
		{
			if (strpos($node->getAttribute('name'), '{') !== false)
			{
				throw new UnsafeTemplateException('Dynamic <xsl:element/> names are disallowed', $node);
			}
		}
	}
}