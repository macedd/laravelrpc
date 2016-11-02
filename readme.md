[![CircleCI](https://circleci.com/gh/thiagof/laravelrpc.svg?style=svg)](https://circleci.com/gh/thiagof/laravelrpc)

### Installation

    # composer
    composer require thiagof/laravelrpc

    # laravel config
    php artisan config:publish thiagof/laravelrpc
    # Laravel > 5.1
    php artisan vendor:publish --provider="Thiagof\LaravelRPC\RpcServiceProvider"



### Configuration

    # app/config/app.php
    # include the provider
    'providers' => array(
        [...]
        'Thiagof\LaravelRPC\RpcServiceProvider',
    );

    # include the alias
    'providers' => array(
        [...]
        'Thiagof\LaravelRPC\RpcClientFacade',
        'Thiagof\LaravelRPC\RpcServerFacade',
    );

Setup your Client/Server properties in your app `config/rpc.php`

### Usage

The Client

    use RpcClient;
    $result = RpcClient::myServerMethod();

The Server
    
    Route::post('rpc', function() {
      $server = app('JsonRpcServer');
      $server->attach(new MyRpcMethods);
      $server->execute();
    });


### Further underlying API Reference

Please refer to [fguillot/json-rpc](https://github.com/fguillot/JsonRPC)