<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator;

use ArrayAccess;
use Iterator;
use akmaljp\DriveMaru\Configurator\Collections\TemplateCheckList;
use akmaljp\DriveMaru\Configurator\Helpers\TemplateHelper;
use akmaljp\DriveMaru\Configurator\Items\Tag;
use akmaljp\DriveMaru\Configurator\Items\UnsafeTemplate;
use akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowElementNS;
use akmaljp\DriveMaru\Configurator\TemplateChecks\DisallowXPathFunction;
use akmaljp\DriveMaru\Configurator\TemplateChecks\RestrictFlashScriptAccess;
use akmaljp\DriveMaru\Configurator\Traits\CollectionProxy;

/**
* @method mixed   add(mixed $value, null $void)
* @method mixed   append(mixed $value)
* @method array   asConfig()
* @method void    clear()
* @method bool    contains(mixed $value)
* @method integer count()
* @method mixed   current()
* @method void    delete(string $key)
* @method bool    exists(string $key)
* @method mixed   get(string $key)
* @method mixed   indexOf(mixed $value)
* @method mixed   insert(integer $offset, mixed $value)
* @method integer|string key()
* @method mixed   next()
* @method integer normalizeKey(mixed $key)
* @method TemplateCheck normalizeValue(mixed $check)
* @method bool    offsetExists(string|integer $offset)
* @method mixed   offsetGet(string|integer $offset)
* @method void    offsetSet(mixed $offset, mixed $value)
* @method void    offsetUnset(string|integer $offset)
* @method string  onDuplicate(string|null $action)
* @method mixed   prepend(mixed $value)
* @method integer remove(mixed $value)
* @method void    rewind()
* @method mixed   set(string $key, mixed $value)
* @method bool    valid()
*/
class TemplateChecker implements ArrayAccess, Iterator
{
	use CollectionProxy;

	/**
	* @var TemplateCheckList Collection of TemplateCheck instances
	*/
	protected $collection;

	/**
	* @var bool Whether checks are currently disabled
	*/
	protected $disabled = false;

	/**
	* Constructor
	*
	* Will load the default checks
	*/
	public function __construct()
	{
		$this->collection = new TemplateCheckList;
		$this->collection->append('DisallowAttributeSets');
		$this->collection->append('DisallowCopy');
		$this->collection->append('DisallowDisableOutputEscaping');
		$this->collection->append('DisallowDynamicAttributeNames');
		$this->collection->append('DisallowDynamicElementNames');
		$this->collection->append('DisallowObjectParamsWithGeneratedName');
		$this->collection->append('DisallowPHPTags');
		$this->collection->append('DisallowUnsafeCopyOf');
		$this->collection->append('DisallowUnsafeDynamicCSS');
		$this->collection->append('DisallowUnsafeDynamicJS');
		$this->collection->append('DisallowUnsafeDynamicURL');
		$this->collection->append(new DisallowElementNS('http://icl.com/saxon', 'output'));
		$this->collection->append(new DisallowXPathFunction('document'));
		$this->collection->append(new RestrictFlashScriptAccess('sameDomain', true));
	}

	/**
	* Check a given tag's templates for disallowed content
	*
	* @param  Tag  $tag Tag whose templates will be checked
	* @return void
	*/
	public function checkTag(Tag $tag)
	{
		if (isset($tag->template) && !($tag->template instanceof UnsafeTemplate))
		{
			$template = (string) $tag->template;
			$this->checkTemplate($template, $tag);
		}
	}

	/**
	* Check a given template for disallowed content
	*
	* @param  string $template Template
	* @param  Tag    $tag      Tag this template belongs to
	* @return void
	*/
	public function checkTemplate($template, Tag $tag = null)
	{
		if ($this->disabled)
		{
			return;
		}

		if (!isset($tag))
		{
			$tag = new Tag;
		}

		// Load the template into a DOMDocument
		$dom = TemplateHelper::loadTemplate($template);

		foreach ($this->collection as $check)
		{
			$check->check($dom->documentElement, $tag);
		}
	}

	/**
	* Disable all checks
	*
	* @return void
	*/
	public function disable()
	{
		$this->disabled = true;
	}

	/**
	* Enable all checks
	*
	* @return void
	*/
	public function enable()
	{
		$this->disabled = false;
	}
}