<?php

namespace Thiagof\LaravelRPC;

use Illuminate\Support\Facades\Facade;

class RpcClientFacade extends Facade {

    protected static function getFacadeAccessor() { return 'JsonRpcClient'; }

}
