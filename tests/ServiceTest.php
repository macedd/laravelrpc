<?php

use Thiagof\LaravelRPC\RpcClientWrapper;
use	\JsonRPC;

class ServiceTest extends TestCase {

	public function testClient()
	{
		$client = app('JsonRpcClient');

		$this->assertInstanceOf(RpcClientWrapper::class, $client);
	}

	public function testServer()
	{
		$server = app('JsonRpcServer');

		$this->assertInstanceOf(JsonRPC\Server::class, $server);
	}

}
