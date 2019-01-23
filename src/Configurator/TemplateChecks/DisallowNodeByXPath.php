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

class DisallowNodeByXPath extends TemplateCheck
{
	/**
	* @var string XPath query used for locating nodes
	*/
	public $query;

	/**
	* Constructor
	*
	* @param  string $query XPath query used for locating nodes
	*/
	public function __construct($query)
	{
		$this->query = $query;
	}

	/**
	* Test for the presence of an element of given name
	*
	* @param  DOMElement $template <xsl:template/> node
	* @param  Tag        $tag      Tag this template belongs to
	* @return void
	*/
	public function check(DOMElement $template, Tag $tag)
	{
		$xpath = new DOMXPath($template->ownerDocument);

		foreach ($xpath->query($this->query) as $node)
		{
			throw new UnsafeTemplateException("Node '" . $node->nodeName . "' is disallowed because it matches '" . $this->query . "'", $node);
		}
	}
}