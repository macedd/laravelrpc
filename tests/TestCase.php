<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{

		$app = $this->createLaravelApp();
	    $this->registerServiceProviders($app);

	    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

	    return $app;        
	}

	protected function createLaravelApp() {
		$app = new Illuminate\Foundation\Application(
			realpath(__DIR__.'/../')
		);
		$app->singleton(
			'Illuminate\Contracts\Http\Kernel',
			'App\Http\Kernel'
		);
		$app->singleton(
			'Illuminate\Contracts\Console\Kernel',
			'App\Console\Kernel'
		);
		$app->singleton(
			'Illuminate\Contracts\Debug\ExceptionHandler',
			'App\Exceptions\Handler'
		);

		return $app;
	}

	protected function registerServiceProviders($app) {
	    $app->register('Thiagof\LaravelRPC\RpcServiceProvider');
	}

	protected function registerAlias($app) {
	    $app->register('Thiagof\LaravelRPC\RpcServiceProvider');
	}

}
