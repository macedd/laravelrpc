<?php

class ServerTest extends TestCase {

	public function testRegister()
	{
        $subtract = function($minuend, $subtrahend) {
            return $minuend - $subtrahend;
        };

		$payload = '{"jsonrpc": "2.0", "method": "subtract", "params": [42, 23], "id": 1}';
		$server = app()->make('JsonRpcServer', [$payload]);
        $server->register('subtract', $subtract);

        $this->assertEquals(
            json_decode('{"jsonrpc": "2.0", "result": 19, "id": 1}', true),
            json_decode($server->execute(), true)
        );
	}

}
