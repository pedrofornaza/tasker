<?php

namespace Tasker\Application;

use PDO;
use Tasker\Application\Container;

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
		$result = $router->match($uri, $method);
		if (!$result) {
			echo "<h1>The requested controller could not be found</h1>";
			exit;
		}

		if (!class_exists($result['target'])) {
			echo "<h1>The controller does not exists</h1>";
			exit;
		}

		$controllerInstance = new $result['target']($this->container);
		$params = $result['params'];

		$response = call_user_func_array(array($controllerInstance, $method), $params);
		echo $response;
		exit;
	}
}