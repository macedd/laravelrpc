### Installation

    # composer
    composer require thiagof/laravelrpc

    # laravel config
    php artisan config:publish thiagof/laravelrpc


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

    use RpcClient;
    $result = RpcClient::myServerMethod();