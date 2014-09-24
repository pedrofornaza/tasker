<?php

namespace Tasker\Infra\Routing;

class Route
{
	protected $uri;
	protected $method;
	protected $target;

	public function __construct($uri, $method, $target)
	{
		$this->uri = $uri;
		$this->method = $method;
		$this->target = $target;
	}

	public function getUri()
	{
		return $this->uri;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function getTarget()
	{
		return $this->target;
	}
}