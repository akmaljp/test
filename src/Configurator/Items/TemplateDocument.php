<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Items;

use DOMDocument;
use akmaljp\DriveMaru\Configurator\Helpers\TemplateHelper;

class TemplateDocument extends DOMDocument
{
	/**
	* @var Template Template instance that created this document
	*/
	protected $template;

	/**
	* Constructor
	*
	* @param Template Template instance that created this document
	*/
	public function __construct(Template $template)
	{
		$this->template = $template;
	}

	/**
	* Update the original template with this document's content
	*
	* @return void
	*/
	public function saveChanges()
	{
		$this->template->setContent(TemplateHelper::saveTemplate($this));
	}
}