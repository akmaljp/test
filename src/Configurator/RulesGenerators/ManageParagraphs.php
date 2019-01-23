<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\RulesGenerators;

use akmaljp\DriveMaru\Configurator\Helpers\TemplateInspector;
use akmaljp\DriveMaru\Configurator\RulesGenerators\Interfaces\BooleanRulesGenerator;

class ManageParagraphs implements BooleanRulesGenerator
{
	/**
	* @var TemplateInspector
	*/
	protected $p;

	/**
	* Constructor
	*
	* Prepares the TemplateInspector for <p/>
	*/
	public function __construct()
	{
		$this->p = new TemplateInspector('<p><xsl:apply-templates/></p>');
	}

	/**
	* {@inheritdoc}
	*/
	public function generateBooleanRules(TemplateInspector $src)
	{
		$rules = [];

		if ($src->allowsChild($this->p) && $src->isBlock() && !$this->p->closesParent($src))
		{
			$rules['createParagraphs'] = true;
		}

		if ($src->closesParent($this->p))
		{
			$rules['breakParagraph'] = true;
		}

		return $rules;
	}
}