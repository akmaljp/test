<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\Collections;

use RuntimeException;
use akmaljp\DriveMaru\Configurator\Items\Attribute;
use akmaljp\DriveMaru\Configurator\Validators\AttributeName;

class AttributeCollection extends NormalizedCollection
{
	/**
	* {@inheritdoc}
	*/
	protected $onDuplicateAction = 'replace';

	/**
	* {@inheritdoc}
	*/
	protected function getAlreadyExistsException($key)
	{
		return new RuntimeException("Attribute '" . $key . "' already exists");
	}

	/**
	* {@inheritdoc}
	*/
	protected function getNotExistException($key)
	{
		return new RuntimeException("Attribute '" . $key . "' does not exist");
	}

	/**
	* Normalize a key as an attribute name
	*
	* @param  string $key
	* @return string
	*/
	public function normalizeKey($key)
	{
		return AttributeName::normalize($key);
	}

	/**
	* Normalize a value to an instance of Attribute
	*
	* @param  array|null|Attribute $value
	* @return Attribute
	*/
	public function normalizeValue($value)
	{
		return ($value instanceof Attribute)
		     ? $value
		     : new Attribute($value);
	}
}