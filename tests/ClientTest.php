<?php

class ClientTest extends TestCase {

	public function testResponse()
	{
		app('config')->set('rpc.client.url', 'http://localhost');
		$client = app()->make('JsonRpcClient');

        $this->assertEquals(
            -19,
            $client->connection()->parseResponse(json_decode('{"jsonrpc": "2.0", "result": -19, "id": 1}', true))
        );
	}

}
