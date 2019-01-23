<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Items\AttributeFilters;

use akmaljp\DriveMaru\Configurator\Items\AttributeFilter;

class Ipv4Filter extends AttributeFilter
{
	/**
	* Constructor
	*/
	public function __construct()
	{
		parent::__construct('akmaljp\\DriveMaru\\Parser\\AttributeFilters\\NetworkFilter::filterIpv4');
		$this->setJS('NetworkFilter.filterIpv4');
	}
}