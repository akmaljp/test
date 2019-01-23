<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\JavaScript;

use akmaljp\DriveMaru\Utils\Http;

abstract class OnlineMinifier extends Minifier
{
	/**
	* @var \akmaljp\DriveMaru\Utils\Http\Client Client used to perform HTTP request
	*/
	public $httpClient;

	/**
	* Constructor
	*
	* @return void
	*/
	public function __construct()
	{
		$this->httpClient = Http::getClient();
	}
}