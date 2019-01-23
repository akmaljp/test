<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Items\AttributeFilters;

class NumberFilter extends RegexpFilter
{
	/**
	* Constructor
	*/
	public function __construct()
	{
		parent::__construct('/^[0-9]+$/D');
		$this->markAsSafeAsURL();
		$this->markAsSafeInCSS();
		$this->markAsSafeInJS();
	}
}