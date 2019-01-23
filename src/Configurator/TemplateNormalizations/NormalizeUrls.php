<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\TemplateNormalizations;

use DOMAttr;
use DOMElement;
use akmaljp\DriveMaru\Configurator\Helpers\AVTHelper;
use akmaljp\DriveMaru\Configurator\Helpers\TemplateHelper;
use akmaljp\DriveMaru\Parser\AttributeFilters\UrlFilter;

/**
* @link http://dev.w3.org/html5/spec/links.html#attr-hyperlink-href
*/
class NormalizeUrls extends AbstractNormalization
{
	/**
	* {@inheritdoc}
	*/
	protected function getNodes()
	{
		return TemplateHelper::getURLNodes($this->ownerDocument);
	}

	/**
	* {@inheritdoc}
	*/
	protected function normalizeAttribute(DOMAttr $attribute)
	{
		// Trim the URL and parse it
		$tokens = AVTHelper::parse(trim($attribute->value));

		$attrValue = '';
		foreach ($tokens as list($type, $content))
		{
			if ($type === 'literal')
			{
				$attrValue .= UrlFilter::sanitizeUrl($content);
			}
			else
			{
				$attrValue .= '{' . $content . '}';
			}
		}

		// Unescape brackets in the host part
		$attrValue = $this->unescapeBrackets($attrValue);

		// Update the attribute's value
		$attribute->value = htmlspecialchars($attrValue);
	}

	/**
	* {@inheritdoc}
	*/
	protected function normalizeElement(DOMElement $element)
	{
		$query = './/text()[normalize-space() != ""]';
		foreach ($this->xpath($query, $element) as $i => $node)
		{
			$value = UrlFilter::sanitizeUrl($node->nodeValue);

			if (!$i)
			{
				$value = $this->unescapeBrackets(ltrim($value));
			}

			$node->nodeValue = $value;
		}
		if (isset($node))
		{
			$node->nodeValue = rtrim($node->nodeValue);
		}
	}

	/**
	* Unescape brackets in the host part of a URL if it looks like an IPv6 address
	*
	* @param  string $url
	* @return string
	*/
	protected function unescapeBrackets($url)
	{
		return preg_replace('#^(\\w+://)%5B([-\\w:._%]+)%5D#i', '$1[$2]', $url);
	}
}