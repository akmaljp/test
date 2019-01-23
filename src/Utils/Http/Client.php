<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Utils\Http;

abstract class Client
{
	/**
	* @var bool Whether to verify the peer's SSL certificate
	*/
	public $sslVerifyPeer = false;

	/**
	* @var integer Request timeout
	*/
	public $timeout = 10;

	/**
	* Execute a GET request and return the response's body
	*
	* @param  string      $url     Request URL
	* @param  string[]    $headers Request headers
	* @return string|bool          Response body or FALSE
	*/
	abstract public function get($url, $headers = []);

	/**
	* Execute a POST request and return the response's body
	*
	* @param  string      $url     Request URL
	* @param  string[]    $headers Request headers
	* @param  string      $body    Request body
	* @return string|bool          Response body or FALSE
	*/
	abstract public function post($url, $headers = [], $body = '');
}