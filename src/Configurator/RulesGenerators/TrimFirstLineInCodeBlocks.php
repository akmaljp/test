<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\RulesGenerators;

use akmaljp\DriveMaru\Configurator\Helpers\TemplateInspector;
use akmaljp\DriveMaru\Configurator\RulesGenerators\Interfaces\BooleanRulesGenerator;

class TrimFirstLineInCodeBlocks implements BooleanRulesGenerator
{
	/**
	* {@inheritdoc}
	*/
	public function generateBooleanRules(TemplateInspector $src)
	{
		return ($src->evaluate('count(//pre//code//xsl:apply-templates)')) ? ['trimFirstLine' => true] : [];
	}
}