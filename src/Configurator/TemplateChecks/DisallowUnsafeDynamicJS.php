<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\TemplateChecks;

use DOMElement;
use akmaljp\DriveMaru\Configurator\Helpers\XPathHelper;
use akmaljp\DriveMaru\Configurator\Helpers\TemplateHelper;
use akmaljp\DriveMaru\Configurator\Items\Attribute;

class DisallowUnsafeDynamicJS extends AbstractDynamicContentCheck
{
	/**
	* {@inheritdoc}
	*/
	protected function getNodes(DOMElement $template)
	{
		return TemplateHelper::getJSNodes($template->ownerDocument);
	}

	/**
	* {@inheritdoc}
	*/
	protected function isExpressionSafe($expr)
	{
		return XPathHelper::isExpressionNumeric($expr);
	}

	/**
	* {@inheritdoc}
	*/
	protected function isSafe(Attribute $attribute)
	{
		return $attribute->isSafeInJS();
	}
}