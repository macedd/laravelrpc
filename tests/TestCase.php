<?php

use Illuminate\Foundation\AliasLoader;

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
	    $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

	    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

	    $this->registerServiceProviders($app);

	    return $app;        
	}

	protected function registerServiceProviders($app) {
	    $app->register('Thiagof\LaravelRPC\RpcServiceProvider');
	}
}
