<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Items;

use InvalidArgumentException;
use akmaljp\DriveMaru\Configurator\Items\Regexp;

class AttributePreprocessor extends Regexp
{
	/**
	* Return all the attributes created by the preprocessor along with the regexp that matches them
	*
	* @return array Array of [attribute name => regexp]
	*/
	public function getAttributes()
	{
		return $this->getNamedCaptures();
	}
	
	/**
	* Return the regexp this preprocessor is based on
	*
	* @return string
	*/
	public function getRegexp()
	{
		return $this->regexp;
	}
}