<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\TemplateNormalizations;

use DOMNode;

/**
* Remove all inter-element whitespace except for single space characters
*/
class PreserveSingleSpaces extends AbstractNormalization
{
	/**
	* {@inheritdoc}
	*/
	protected $queries = ['//text()[. = " "][not(parent::xsl:text)]'];

	/**
	* {@inheritdoc}
	*/
	protected function normalizeNode(DOMNode $node)
	{
		$node->parentNode->replaceChild($this->createElement('xsl:text', ' '), $node);
	}
}