<?php

namespace Tasker\Infra\Routing;

class Router
{
	protected $dispatcher;
	protected $routes;

	public function __construct(Dispatcher $dispatcher, $routes = array())
	{
		$this->dispatcher = $dispatcher;
		$this->routes = $routes;
	}

	public function handle($requestedUri, $requestedMethod)
	{
		$requestedUri = $this->parseUri($requestedUri);
		$params = $this->getParamsFromUri($requestedUri);

		$slug = $this->buildSlug($requestedUri, $params);

		$route = $this->matchRoute($slug, $requestedMethod);

		$target = $route->getTarget();
		return $this->dispatcher->dispatch($target, $params);
	}

	protected function parseUri($requestedUri)
	{
		$default = '/';
		$requestedUri = trim($requestedUri, '/');

		if ($requestedUri == '') {
			return $default;
		}

		$parsedUri = parse_url($requestedUri);
		if ( ! isset($parsedUri['path'])) {
			return $default;
		}

		return $parsedUri['path'];
	}

	protected function getParamsFromUri($requestedUri)
	{
		$uriParts = explode('/', $requestedUri);
		$params = array();

		$i = 0;
		while($i < count($uriParts)) {
			$next = $i + 1;
			$params[$uriParts[$i]] = isset($uriParts[$next]) ? $uriParts[$next] : null;

			$i = $i + 2;
		}

		return $params;
	}

	protected function buildSlug($requestedUri, $params)
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

	protected function matchRoute($slug, $requestedMethod)
	{
		foreach ($this->routes as $route) {
			if ($slug !== $route->getUri() ||
				$requestedMethod !== $route->getMethod()
			) {
			 	continue;
			}

			return $route;
		}

		throw new Exception(sprintf("A route could not be matched to uri '%s' on the '%s' method ", $slug, $requestedMethod));
	}
}