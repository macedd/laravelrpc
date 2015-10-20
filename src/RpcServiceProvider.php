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
		// Publish config file setup
		$this->publishes([
			__DIR__.'/../config/rpc.php' => config_path('rpc.php'),
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

		// Shared Client
		$this->app->bindShared('JsonRpcClient', function($app)
		{
			$options = config('rpc.client');
			$client = new RpcClientWrapper($options);
			return $client;
		});

		// Shared Server
		$this->app->bindShared('JsonRpcServer', function($app, $payload = '', array $callbacks = array(), array $classes = array())
		{
			$options = config('rpc.server');
			$server = new JsonRPC\Server($payload, $callbacks, $classes);
			return $server;
		});

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
