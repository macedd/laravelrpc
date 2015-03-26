<?php

namespace Thiagof\LaravelRPC;

use JsonRPC;

/**
 * Wraps Client functionality to become more procedural
 * Use call bidings to request server responses
 * 
 * eg.:
 * JsonClient->RemoteProcedure()
 */
class RpcClientWrapper {

    private $connection = null;

    protected $config = array();


    public function __construct($options=[]) {
        $this->configure($options);
    }

    public function configure($options) {
        $this->config = array_merge($this->config, $options);
    }

    /**
     * Gets Client Connection instance, init on demand for reuse
     * @return [type] [description]
     */
    public function connection() {
        if (!$this->connection)
            $this->connection = $this->connection_init();

        return $this->connection;
    }

    /**
     * Inits Client Connection based on instance params
     * @return JsonRPC\Client
     */
    private function connection_init()
    {
        $opts = $this->config;

        $connection = new JsonRPC\Client($opts['url'], $opts['timeout'], $opts['headers']);

        $connection->ssl_verify_peer = $opts['ssl_verify_peer'];
        $connection->debug           = $opts['debug'];

        if ($opts['username']) {
            $connection->authentication($opts['username'], $opts['password']);
        }

        return $connection;
    }

    /**
     * Execute a remote method
     * @param  string $method   Remote method
     * @param  array  $params   Params to be run
     * @return mixed            Response from remote execution
     */
    protected function request($method, $params)
    {
        return call_user_func_array(
                [$this->connection(), 'execute'],
                array_merge([$method], $params)
            );
    }

    /**
     * Static caller of remote methods
     * Allow RPC::RemoteMethod(remote, params)
     * @param  [type] $method_name [description]
     * @param  [type] $arguments   [description]
     * @return [type]              [description]
     */
    public function __call($method_name, $arguments) {
        // named args only
        // $arguments = $arguments[0];
        
        return $this->request($method_name, $arguments);
    }
    
}