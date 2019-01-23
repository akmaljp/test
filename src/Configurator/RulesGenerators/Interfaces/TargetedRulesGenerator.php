<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\RulesGenerators\Interfaces;

use akmaljp\DriveMaru\Configurator\Helpers\TemplateInspector;

interface TargetedRulesGenerator
{
	/**
	* Generate targeted rules that apply to given template inspector
	*
	* @param  TemplateInspector $src Source template inspector
	* @param  TemplateInspector $trg Target template inspector
	* @return array                  List of rules that apply from the source template to the target
	*/
	public function generateTargetedRules(TemplateInspector $src, TemplateInspector $trg);
}