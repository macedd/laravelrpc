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
		$this->app->singleton('JsonRpcClient', function($app)
		{
			$options = $this->app['config']->get('rpc.client');
			$client = new RpcClientWrapper($options);
			return $client;
		});

		// Shared Server
		$this->app->bind('JsonRpcServer', function($app, $params=[])
		{
			$options = $this->app['config']->get('rpc.server');

			$class = new \ReflectionClass(JsonRPC\Server::class);
			$server = $class->newInstanceArgs($params);

			return $server;
		});

	}

	protected function mergeConfigFrom($path, $key='rpc')
	{
		$config = $this->app['config']->get($key, []);
		$config_pkg = require $path;
		$config = array_merge_recursive($config_pkg, $config);

		$this->app['config']->set($key, $config);
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
