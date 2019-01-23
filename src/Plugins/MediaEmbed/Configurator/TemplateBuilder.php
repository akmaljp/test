<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator;

use DOMXPath;
use akmaljp\DriveMaru\Configurator\Helpers\TemplateHelper;
use akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator\TemplateGenerators\Choose;
use akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator\TemplateGenerators\Flash;
use akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator\TemplateGenerators\Iframe;

class TemplateBuilder
{
	/**
	* @var array Generator names as keys, generators as values
	*/
	protected $templateGenerators = [];

	/**
	* Constructor
	*/
	public function __construct()
	{
		$this->templateGenerators['choose'] = new Choose($this);
		$this->templateGenerators['flash']  = new Flash;
		$this->templateGenerators['iframe'] = new Iframe;
	}

	/**
	* Generate and return a template for given site
	*
	* @param  string $siteId
	* @param  array  $siteConfig
	* @return string
	*/
	public function build($siteId, array $siteConfig)
	{
		return $this->addSiteId($siteId, $this->getTemplate($siteConfig));
	}

	/**
	* Generate and return a template based on given config
	*
	* @param  array  $config
	* @return string
	*/
	public function getTemplate(array $config)
	{
		foreach ($this->templateGenerators as $type => $generator)
		{
			if (isset($config[$type]))
			{
				return $generator->getTemplate($config[$type]);
			}
		}

		return '';
	}

	/**
	* Added the siteId value to given template in a data-akmaljp-mediaembed attribute
	*
	* @param  string $siteId   Site ID
	* @param  string $template Original template
	* @return string           Modified template
	*/
	protected function addSiteId($siteId, $template)
	{
		$dom   = TemplateHelper::loadTemplate($template);
		$xpath = new DOMXPath($dom);
		$query = '//*[namespace-uri() != "' . TemplateHelper::XMLNS_XSL . '"]'
		       . '[not(ancestor::*[namespace-uri() != "' . TemplateHelper::XMLNS_XSL . '"])]';
		foreach ($xpath->query($query) as $element)
		{
			$element->setAttribute('data-akmaljp-mediaembed', $siteId);
		}

		return TemplateHelper::saveTemplate($dom);
	}
}