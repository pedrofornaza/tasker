<?php

namespace Tasker\Infra\Routing\Dispatcher;

use Tasker\Infra\Container;
use Tasker\Infra\Routing\Dispatcher;

class ContainerDispatcher implements Dispatcher
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function dispatch($target, $params)
    {
        $method = '__invoke';

        if (strpos($target, '::') !== false) {
            list($target, $method) = explode('::', $target);
        }

        $controllerInstance = $this->container->make($target);

        return call_user_func_array(array($controllerInstance, $method), $params);
    }
}