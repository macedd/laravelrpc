Installation

    # composer
    composer require thiagof/laravel-jsonrpc
    # laravel config
    php artisan config:publish thiagof/laravel-jsonrpc


Configuration


    # app/config/app.php
    # include the provider
    'providers' => array(
        [...]
        'Thiagof\JsonRPC\JsonRPCServiceProvider',
    );
