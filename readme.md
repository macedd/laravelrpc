[![CircleCI](https://circleci.com/gh/macedd/laravelrpc.svg?style=svg)](https://circleci.com/gh/macedd/laravelrpc)

### Installation

With composer

    composer require thiagof/laravelrpc

Laravel configuration

    php artisan config:publish thiagof/laravelrpc
    # Laravel > 5.1
    php artisan vendor:publish --provider="Thiagof\LaravelRPC\RpcServiceProvider"



### Configuration

Include the provider in `app/config/app.php`:

    'providers' => array(
        [...]
        'Thiagof\LaravelRPC\RpcServiceProvider',
    );

Also include the alias

    'providers' => array(
        [...]
        'Thiagof\LaravelRPC\RpcClientFacade',
        'Thiagof\LaravelRPC\RpcServerFacade',
    );

Setup your Client/Server properties in your app `config/rpc.php`

### Usage

The Client

    <?php
    use RpcClient;
    $result = RpcClient::myServerMethod();

The Server
    
    <?php
    Route::post('rpc', function() {
      $server = app('JsonRpcServer');
      $server->attach(new MyRpcMethods);
      $server->execute();
    });


### Further underlying API Reference

Please refer to [fguillot/json-rpc](https://github.com/matasarei/json-rpc/tree/v1.0.3)