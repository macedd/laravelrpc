Installation

    # composer
    composer require thiagof/laravelrpc


Configuration


    # app/config/app.php
    # include the provider
    'providers' => array(
        [...]
        'Thiagof\LaravelRPC\RpcServiceProvider',
    );

    # laravel config
    php artisan vendor:publish