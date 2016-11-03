<?php

use Illuminate\Foundation\AliasLoader;

class ServiceConfigTest extends TestCase {

	public function createApplication()
	{
	    $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

	    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

	    // Initial config (user defined)
	    $this->config = [
			'client' => [
        		'url' => 'http://example.com/jsonrpc',
			]
		];
		app('config')->set('rpc', $this->config);

	    $this->registerServiceProviders($app);
	    return $app;
	}

	public function testConfigDefault() {
		$rpc_config = app('config')->get('rpc');

		$this->assertContains('client', array_keys($rpc_config));
		$this->assertContains('server', array_keys($rpc_config));
		$this->assertContains('timeout', array_keys($rpc_config['client']));
		$this->assertContains('headers', array_keys($rpc_config['client']));
	}

	public function testConfigUser() {
		$rpc_config = app('config')->get('rpc');

		$this->assertEquals($this->config['client']['url'], $rpc_config['client']['url']);
	}
}
