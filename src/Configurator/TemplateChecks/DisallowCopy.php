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

class DisallowCopy extends TemplateCheck
{
	/**
	* Check for <xsl:copy/> elements
	*
	* @param  DOMElement $template <xsl:template/> node
	* @param  Tag        $tag      Tag this template belongs to
	* @return void
	*/
	public function check(DOMElement $template, Tag $tag)
	{
		$nodes = $template->getElementsByTagNameNS(self::XMLNS_XSL, 'copy');
		$node  = $nodes->item(0);

		if ($node)
		{
			throw new UnsafeTemplateException("Cannot assess the safety of an '" . $node->nodeName . "' element", $node);
		}
	}
}