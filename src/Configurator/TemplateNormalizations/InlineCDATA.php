<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\TemplateNormalizations;

use DOMNode;

class InlineCDATA extends AbstractNormalization
{
	/**
	* {@inheritdoc}
	*/
	protected $queries = ['//text()'];

	/**
	* {@inheritdoc}
	*/
	protected function normalizeNode(DOMNode $node)
	{
		if ($node->nodeType === XML_CDATA_SECTION_NODE)
		{
			$node->parentNode->replaceChild($this->createTextNode($node->textContent), $node);
		}
	}
}