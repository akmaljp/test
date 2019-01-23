<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Utils;

use akmaljp\DriveMaru\Utils\Http\Clients\Cached;
use akmaljp\DriveMaru\Utils\Http\Clients\Curl;
use akmaljp\DriveMaru\Utils\Http\Clients\Native;

abstract class Http
{
	/**
	* Instantiate and return an HTTP client
	*
	* @return Http\Client
	*/
	public static function getClient()
	{
		return (extension_loaded('curl')) ? new Curl : new Native;
	}
	/**
	* Instantiate and return a caching HTTP client
	*
	* @param  string $cacheDir
	* @return Cached
	*/
	public static function getCachingClient($cacheDir = null)
	{
		$client = new Cached(self::getClient());
		$client->cacheDir = (isset($cacheDir)) ? $cacheDir : sys_get_temp_dir();

		return $client;
	}
}