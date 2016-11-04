<?php

namespace Thiagof\LaravelRPC;

use Log, Cache;
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

        // Headers format
        $headers = [];
        foreach ($opts['headers'] as $key => $value)
            $headers[] = "$key: $value";

        $connection = new JsonRPC\Client($opts['url'], $opts['timeout'], $headers);

        $connection->ssl_verify_peer = $opts['ssl_verify_peer'];
        $connection->debug           = $opts['debug'];
        $connection->named_arguments = isset($opts['named_arguments']) && $opts['named_arguments']===true;

        if (isset($opts['username']) && $opts['username']) {
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
        Log::debug('RpcClient call', ['method'=>$method, 'params'=>$params, 'config'=>$this->config]);

        return call_user_func_array(
                [$this->connection(), 'execute'],
                [$method,$params]
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
        
        
        if ($this->cache_allowed($method_name))
        {
            $key = "rpc-$method_name-". md5(json_encode($arguments));
            $time = $this->config['cache_duration'];

            $request = [$this, 'request'];

            return Cache::remember($key, $time, function() use ($method_name, $arguments, $request) {
                return $request($method_name, $arguments);
            });
        }
        
        return $this->request($method_name, $arguments);
    }

    protected function cache_allowed($method_name) {
        $allow = $this->config['cache'];
        if (!is_array($allow))
            $allow = [$allow];

        if (in_array('*', $allow))
            return true;
        if (in_array($method_name, $allow))
            return true;

        return false;
    }
    
}