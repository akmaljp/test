<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\RulesGenerators\Interfaces;

use akmaljp\DriveMaru\Configurator\Helpers\TemplateInspector;

interface BooleanRulesGenerator
{
	/**
	* Generate boolean rules that apply to given template inspector
	*
	* @param  TemplateInspector $src Source template inspector
	* @return array                  Array of boolean rules as [ruleName => bool]
	*/
	public function generateBooleanRules(TemplateInspector $src);
}