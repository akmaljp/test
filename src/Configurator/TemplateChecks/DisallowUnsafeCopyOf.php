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

class DisallowUnsafeCopyOf extends TemplateCheck
{
	/**
	* Check for unsafe <xsl:copy-of/> elements
	*
	* Any select expression that is not a set of named attributes is considered unsafe
	*
	* @param  DOMElement $template <xsl:template/> node
	* @param  Tag        $tag      Tag this template belongs to
	* @return void
	*/
	public function check(DOMElement $template, Tag $tag)
	{
		$nodes = $template->getElementsByTagNameNS(self::XMLNS_XSL, 'copy-of');
		foreach ($nodes as $node)
		{
			$expr = $node->getAttribute('select');

			if (!preg_match('#^@[-\\w]*(?:\\s*\\|\\s*@[-\\w]*)*$#D', $expr))
			{
				throw new UnsafeTemplateException("Cannot assess the safety of '" . $node->nodeName . "' select expression '" . $expr . "'", $node);
			}
		}
	}
}