<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\TemplateNormalizations;

use DOMNode;

/**
* Convert comments into xsl:comment elements
*/
class TransposeComments extends AbstractNormalization
{
	/**
	* {@inheritdoc}
	*/
	protected $queries = ['//comment()'];

	/**
	* {@inheritdoc}
	*/
	protected function normalizeNode(DOMNode $node)
	{
		$xslComment = $this->createElement('xsl:comment', $node->nodeValue);
		$node->parentNode->replaceChild($xslComment, $node);
	}
}