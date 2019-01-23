<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\TemplateNormalizations;

use DOMElement;

class Custom extends AbstractNormalization
{
	/**
	* @var callback Normalization callback
	*/
	protected $callback;

	/**
	* Constructor
	*
	* @param  callback $callback Normalization callback
	*/
	public function __construct(callable $callback)
	{
		$this->callback = $callback;
	}

	/**
	* Call the user-supplied callback
	*
	* @param  DOMElement $template <xsl:template/> node
	* @return void
	*/
	public function normalize(DOMElement $template)
	{
		call_user_func($this->callback, $template);
	}
}