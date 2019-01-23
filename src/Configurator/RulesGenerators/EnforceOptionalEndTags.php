<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\RulesGenerators;

use akmaljp\DriveMaru\Configurator\Helpers\TemplateInspector;
use akmaljp\DriveMaru\Configurator\RulesGenerators\Interfaces\TargetedRulesGenerator;

class EnforceOptionalEndTags implements TargetedRulesGenerator
{
	/**
	* {@inheritdoc}
	*/
	public function generateTargetedRules(TemplateInspector $src, TemplateInspector $trg)
	{
		return ($src->closesParent($trg)) ? ['closeParent'] : [];
	}
}