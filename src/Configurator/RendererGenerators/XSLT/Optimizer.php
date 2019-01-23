<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\RendererGenerators\XSLT;

use akmaljp\DriveMaru\Configurator\TemplateNormalizer;

class Optimizer
{
	/**
	* @var TemplateNormalizer
	*/
	public $normalizer;

	/**
	* Constructor
	*/
	public function __construct()
	{
		$this->normalizer = new TemplateNormalizer;
		$this->normalizer->clear();
		$this->normalizer->append('MergeConsecutiveCopyOf');
		$this->normalizer->append('MergeIdenticalConditionalBranches');
		$this->normalizer->append('OptimizeNestedConditionals');
		$this->normalizer->append('RemoveLivePreviewAttributes');
	}

	/**
	* Optimize a single template
	*
	* @param  string $template Original template
	* @return string           Optimized template
	*/
	public function optimizeTemplate($template)
	{
		return $this->normalizer->normalizeTemplate($template);
	}
}