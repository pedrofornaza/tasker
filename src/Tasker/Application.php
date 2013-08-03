<?php

namespace Tasker;

class Application
{
	public function __construct(\PDO $db)
	{
		$this->db = $db;
	}

	public function run($request)
	{
		$uri = trim($request['REQUEST_URI'], '/');
		list($controller, $id) = explode('/', $uri);
		$method = strtolower($request['REQUEST_METHOD']);

		$controllerName = 'Tasker\Controllers\\'.ucfirst($controller);
		if (!class_exists($controllerName)) {
			echo "<h1>The requested controller '{$controller}' could not be found</h1>";
			exit;
		}

		$controllerInstance = new $controllerName($this->db);
		$params = array();
		if ($id !== null) {
			array_push($params, $id);
		}

		$response = call_user_func_array(array($controllerInstance, $method), $params);
		echo $response;
		exit;
	}
}