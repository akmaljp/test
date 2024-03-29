<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\TemplateNormalizations;

use DOMElement;
use akmaljp\DriveMaru\Configurator\Helpers\ElementInspector;

/**
* Enforce omitted/optional HTML 5 end tags and fix the DOM
*
* Will replace
*     <p>.<p>.</p></p>
* with
*     <p>.</p><p>.</p>
*/
class EnforceHTMLOmittedEndTags extends AbstractNormalization
{
	/**
	* {@inheritdoc}
	*/
	protected $queries = ['//*[namespace-uri() = ""]/*[namespace-uri() = ""]'];

	/**
	* {@inheritdoc}
	*/
	protected function normalizeElement(DOMElement $element)
	{
		$parentNode = $element->parentNode;
		if (ElementInspector::isVoid($parentNode) || ElementInspector::closesParent($element, $parentNode))
		{
			$this->reparentElement($element);
		}
	}

	/**
	* Move given element and its following siblings after its parent element
	*
	* @param  DOMElement $element First element to move
	* @return void
	*/
	protected function reparentElement(DOMElement $element)
	{
		$parentNode = $element->parentNode;
		do
		{
			$lastChild = $parentNode->lastChild;
			$parentNode->parentNode->insertBefore($lastChild, $parentNode->nextSibling);
		}
		while (!$lastChild->isSameNode($element));
	}
}