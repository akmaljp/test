<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\TemplateChecks;

use DOMElement;
use DOMXPath;
use akmaljp\DriveMaru\Configurator\Exceptions\UnsafeTemplateException;
use akmaljp\DriveMaru\Configurator\Items\Tag;
use akmaljp\DriveMaru\Configurator\TemplateCheck;

class DisallowDisableOutputEscaping extends TemplateCheck
{
	/**
	* Check a template for any tag using @disable-output-escaping
	*
	* @param  DOMElement $template <xsl:template/> node
	* @param  Tag        $tag      Tag this template belongs to
	* @return void
	*/
	public function check(DOMElement $template, Tag $tag)
	{
		$xpath = new DOMXPath($template->ownerDocument);
		$node  = $xpath->query('//@disable-output-escaping')->item(0);

		if ($node)
		{
			throw new UnsafeTemplateException("The template contains a 'disable-output-escaping' attribute", $node);
		}
	}
}