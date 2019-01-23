<?php

namespace akmaljp\DriveMaru\Tests\Utils\Http\Clients;

use akmaljp\DriveMaru\Utils\Http\Clients\Curl;

class CurlTest extends AbstractTest
{
	/**
	* @beforeClass
	*/
	public static function removeCachedHandle()
	{
		HandleRemover::removeHandle();
	}

	protected function getInstance()
	{
		return new Curl;
	}
}

class HandleRemover extends Curl
{
	public static function removeHandle()
	{
		self::$handle = null;
	}
}