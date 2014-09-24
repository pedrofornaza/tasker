<?php

namespace Tasker\Application;

use PDO;
use Tasker\Infra\Container;

class Application
{
	protected $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	public function run($request)
	{
		$uri = trim($request['REQUEST_URI'], '/');
		$method = strtolower($request['REQUEST_METHOD']);

		$router = $this->container['router'];
		$response = $router->handle($uri, $method);

		echo $response;
	}
}