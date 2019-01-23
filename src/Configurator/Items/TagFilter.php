<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Items;

class TagFilter extends Filter
{
	/**
	* Constructor
	*
	* @param  callable $callback
	*/
	public function __construct($callback)
	{
		parent::__construct($callback);

		// Set the default signature
		$this->resetParameters();
		$this->addParameterByName('tag');
	}
}