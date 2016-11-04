<?php
namespace Thiagof\LaravelRPC;

use Illuminate\Support\Facades\Facade;

class RpcServerFacade extends Facade {

    protected static function getFacadeAccessor() { return 'JsonRpcServer'; }

}
