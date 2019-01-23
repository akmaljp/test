<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\TemplateNormalizations;

use DOMAttr;
use DOMElement;

/**
* Remove attributes related to live preview
*/
class RemoveLivePreviewAttributes extends AbstractNormalization
{
	/**
	* {@inheritdoc}
	*/
	protected $queries = [
		'//@*           [starts-with(name(), "data-akmaljp-livepreview-")]',
		'//xsl:attribute[starts-with(@name,  "data-akmaljp-livepreview-")]'
	];

	/**
	* {@inheritdoc}
	*/
	protected function normalizeAttribute(DOMAttr $attribute)
	{
		$attribute->parentNode->removeAttributeNode($attribute);
	}

	/**
	* {@inheritdoc}
	*/
	protected function normalizeElement(DOMElement $element)
	{
		$element->parentNode->removeChild($element);
	}
}