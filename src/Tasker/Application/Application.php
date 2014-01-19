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
		list($controller, $id) = explode('/', $uri);
		$method = strtolower($request['REQUEST_METHOD']);

		$controllerName = 'Tasker\Application\Controllers\\'.ucfirst($controller);
		if (!class_exists($controllerName)) {
			echo "<h1>The requested controller '{$controller}' could not be found</h1>";
			exit;
		}

		$controllerInstance = new $controllerName($this->container);
		$params = array();
		if ($id !== null) {
			array_push($params, $id);
		}

		$response = call_user_func_array(array($controllerInstance, $method), $params);
		echo $response;
		exit;
	}
}