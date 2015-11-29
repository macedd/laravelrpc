<?php

return array(

    'client' => [
        /**
         * Server URL
         */
        'url' => env('RPC_URL', 'http://example.com/jsonrpc'),

        /**
         * HTTP client timeout
         */
        'timeout'    => 5,

        /**
         * Custom HTTP headers
         */
        'headers'    => array(),

        /**
         * Username for authentication
         */
        'username' => false,
        'password' => null,

        /**
         * Enable debug output to the php error log
         */
        'debug' => false,

        /**
         * SSL certificates verification
         */
        'ssl_verify_peer' => env('RPC_SSL', true),

        /**
         * Methods to Cache
         * '*' to allow all, and 'method_name' to single method
         */
        'cache' => null,

        'cache_duration' => 15,
    ],

    'server' => [
    ],

);