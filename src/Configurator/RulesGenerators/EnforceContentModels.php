<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\RulesGenerators;

use akmaljp\DriveMaru\Configurator\Helpers\TemplateInspector;
use akmaljp\DriveMaru\Configurator\RulesGenerators\Interfaces\BooleanRulesGenerator;
use akmaljp\DriveMaru\Configurator\RulesGenerators\Interfaces\TargetedRulesGenerator;

class EnforceContentModels implements BooleanRulesGenerator, TargetedRulesGenerator
{
	/**
	* @var TemplateInspector
	*/
	protected $br;

	/**
	* @var TemplateInspector
	*/
	protected $span;

	/**
	* Constructor
	*
	* Prepares the TemplateInspector for <br/> and <span>
	*/
	public function __construct()
	{
		$this->br   = new TemplateInspector('<br/>');
		$this->span = new TemplateInspector('<span><xsl:apply-templates/></span>');
	}

	/**
	* {@inheritdoc}
	*/
	public function generateBooleanRules(TemplateInspector $src)
	{
		$rules = [];
		if ($src->isTransparent())
		{
			$rules['isTransparent'] = true;
		}
		if (!$src->allowsChild($this->br))
		{
			$rules['preventLineBreaks'] = true;
			$rules['suspendAutoLineBreaks'] = true;
		}
		if (!$src->allowsDescendant($this->br))
		{
			$rules['disableAutoLineBreaks'] = true;
			$rules['preventLineBreaks'] = true;
		}

		return $rules;
	}

	/**
	* {@inheritdoc}
	*/
	public function generateTargetedRules(TemplateInspector $src, TemplateInspector $trg)
	{
		$rules = [];
		if ($src->allowsChild($trg))
		{
			$rules[] = 'allowChild';
		}
		if ($src->allowsDescendant($trg))
		{
			$rules[] = 'allowDescendant';
		}

		return $rules;
	}
}