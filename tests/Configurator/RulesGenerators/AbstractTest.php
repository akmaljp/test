<?php

namespace akmaljp\DriveMaru\Tests\Configurator\RulesGenerators;

use akmaljp\DriveMaru\Configurator\Helpers\TemplateInspector;
use akmaljp\DriveMaru\Tests\Test;

abstract class AbstractTest extends Test
{
	public function assertBooleanRules($template, $expected)
	{
		$className = get_class($this);
		$className = 'akmaljp\\DriveMaru\\Configurator\\RulesGenerators'
		           . substr($className, strrpos($className, '\\'), -4);

		$rulesGenerator = new $className;
		$this->assertEquals(
			$expected,
			$rulesGenerator->generateBooleanRules(new TemplateInspector($template))
		);
	}

	public function assertTargetedRules($src, $trg, $expected)
	{
		$className = get_class($this);
		$className = 'akmaljp\\DriveMaru\\Configurator\\RulesGenerators'
		           . substr($className, strrpos($className, '\\'), -4);

		$rulesGenerator = new $className;
		$this->assertEquals(
			$expected,
			$rulesGenerator->generateTargetedRules(
				new TemplateInspector($src),
				new TemplateInspector($trg)
			)
		);
	}
}