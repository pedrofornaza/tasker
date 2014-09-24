<?php

namespace Tasker\Infra\Routing;

interface Dispatcher
{
    public function dispatch($target, $params);
}