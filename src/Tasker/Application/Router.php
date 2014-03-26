<?php

namespace Tasker\Application;

class Router
{
	protected $routes;

	public function __construct($routes = array())
	{
		$this->routes = $routes;
	}

	public function match($requestedUri, $requestedMethod)
	{
		$requestedUri = trim($requestedUri, '/');

		$slug = '/';
		$params = array();
		if ($requestedUri !== '') {
			$parsedUri = parse_url($requestedUri);
			if (!isset($parsedUri['path'])) {
				return false;
			}

			$requestedUri = $parsedUri['path'];

			$requestedParts = explode('/', $requestedUri);
			$params = $this->getParams($requestedParts);

			$slug = $this->buildSlug($requestedUri, $params);
		}

		foreach ($this->routes as $route) {

			if ($slug !== $route->getUri() ||
				$requestedMethod !== $route->getMethod()
			) {
			 	continue;
			}

			return array('target' => $route->getTarget(), 'params' => $params);
		}

		return false;
	}

	public function buildSlug($requestedUri, $params)
	{
		$slug = '';
		foreach ($params as $name => $value) {
			$slug .= '/'.$name;

			if ($value == null) {
				continue;
			}

			$slug .= '/:id';
		}

		return $slug;
	}

	public function getParams($uriParts)
	{
		$params = array();
		
		$i = 0; 
		while($i < count($uriParts)) {
			$next = $i + 1;
			$params[$uriParts[$i]] = isset($uriParts[$next]) ? $uriParts[$next] : null;

			$i = $i + 2;
		}

		return $params;
	}
}