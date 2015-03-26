<?php

namespace Thiagof\LaravelRPC;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use	JsonRPC;

class RpcServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Config setup
		$this->publishes([
			__DIR__.'/../config/rpc.php' => base_path('config/rpc.php'),
		]);

		// Register Facades
        $loader = AliasLoader::getInstance();
        $loader->alias('RpcClient', 'Thiagof\LaravelRPC\RpcClientFacade');
        $loader->alias('RpcServer', 'Thiagof\LaravelRPC\RpcServerFacade');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(__DIR__.'/../config/rpc.php', 'rpc');

		$this->app->bindShared('JsonRpcClient', function($app) {
			$options = config('rpc.client');

			$client = new RpcClientWrapper();
			$client->configure($options);

			return $client;
		});

		$this->app->bindShared('JsonRpcServer', function($app) {
			$options = config('rpc.server');

			$server = new JsonRPC\Server();
			
			return $server;
		});

	}

	protected function mergeConfigFrom($path, $key='rpc')
	{
		$config = $this->app['config']->get($key, []);
		$config_pkg = require $path;

		$this->app['config']->set("$key.client", array_merge($config_pkg['client'], $config['client']));
		$this->app['config']->set("$key.server", array_merge($config_pkg['server'], $config['server']));
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('JsonRpcClient', 'JsonRpcServer');
	}

}
