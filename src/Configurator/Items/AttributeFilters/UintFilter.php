<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilter;

class UintFilter extends AttributeFilter
{
	/**
	* Constructor
	*/
	public function __construct()
	{
		parent::__construct('akmaljp\\DriveMaru\\Parser\\AttributeFilters\\NumericFilter::filterUint');
		$this->setJS('NumericFilter.filterUint');
	}

	/**
	* {@inheritdoc}
	*/
	public function isSafeInCSS()
	{
		return true;
	}

	/**
	* {@inheritdoc}
	*/
	public function isSafeInJS()
	{
		return true;
	}

	/**
	* {@inheritdoc}
	*/
	public function isSafeAsURL()
	{
		return true;
	}
}