<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Collections;

use akmaljp\DriveMaru\Configurator\TemplateCheck;

class TemplateCheckList extends NormalizedList
{
	/**
	* Normalize the value to an instance of TemplateCheck
	*
	* @param  mixed         $check Either a string, or an instance of TemplateCheck
	* @return TemplateCheck        An instance of TemplateCheck
	*/
	public function normalizeValue($check)
	{
		if (!($check instanceof TemplateCheck))
		{
			$className = 'akmaljp\\DriveMaru\\Configurator\\TemplateChecks\\' . $check;
			$check     = new $className;
		}

		return $check;
	}
}