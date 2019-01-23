<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator\TemplateGenerators;

use akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator\TemplateGenerator;

class Iframe extends TemplateGenerator
{
	/**
	* @var array Default iframe attributes
	*/
	protected $defaultIframeAttributes = [
		'allowfullscreen' => '',
		'scrolling'       => 'no',
		'style'           => ['border' => '0']
	];

	/**
	* @var string[] List of attributes to be passed to the iframe
	*/
	protected $iframeAttributes = ['allow', 'data-akmaljp-livepreview-ignore-attrs', 'data-akmaljp-livepreview-postprocess', 'onload', 'scrolling', 'src', 'style'];

	/**
	* {@inheritdoc}
	*/
	protected function getContentTemplate()
	{
		$attributes = $this->mergeAttributes($this->defaultIframeAttributes, $this->getFilteredAttributes());

		return '<iframe>' . $this->generateAttributes($attributes) . '</iframe>';
	}

	/**
	* Filter the attributes to keep only those that can be used in an iframe
	*
	* @return array
	*/
	protected function getFilteredAttributes()
	{
		return array_intersect_key($this->attributes, array_flip($this->iframeAttributes));
	}
}