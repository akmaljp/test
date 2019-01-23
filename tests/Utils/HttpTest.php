<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Helpers;

use akmaljp\DriveMaru\Utils\Http;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Utils\Http
*/
class HttpTest extends Test
{
	/**
	* @testdox getClient() returns an instance of akmaljp\DriveMaru\Utils\Http\Client
	*/
	public function testGetClient()
	{
		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Utils\\Http\\Client',
			Http::getClient()
		);
	}

	/**
	* @testdox getCachingClient() returns an instance of akmaljp\DriveMaru\Utils\Http\Clients\Cached that implements akmaljp\DriveMaru\Utils\Http\Client
	*/
	public function testGetCachingClient()
	{
		$client = Http::getCachingClient();
		$this->assertInstanceOf('akmaljp\\DriveMaru\\Utils\\Http\\Client',          $client);
		$this->assertInstanceOf('akmaljp\\DriveMaru\\Utils\\Http\\Clients\\Cached', $client);
	}
}