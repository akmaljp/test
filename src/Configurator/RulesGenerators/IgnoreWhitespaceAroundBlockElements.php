<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\RulesGenerators;

use akmaljp\DriveMaru\Configurator\Helpers\TemplateInspector;
use akmaljp\DriveMaru\Configurator\RulesGenerators\Interfaces\BooleanRulesGenerator;

class IgnoreWhitespaceAroundBlockElements implements BooleanRulesGenerator
{
	/**
	* {@inheritdoc}
	*/
	public function generateBooleanRules(TemplateInspector $src)
	{
		return ($src->isBlock()) ? ['ignoreSurroundingWhitespace' => true] : [];
	}
}