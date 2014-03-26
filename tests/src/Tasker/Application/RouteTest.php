<?php

use Tasker\Application\Route;

class RouteTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Tasker\Application\Route;
	 */
	protected $instance;

	public function setUp()
	{
		$this->instance = new Route('/uri', 'method', 'target');
	}

	public function testGetUri()
	{
		$this->assertEquals('/uri', $this->instance->getUri());
	}

	public function testGetMethod()
	{
		$this->assertEquals('method', $this->instance->getMethod());
	}

	public function testGetTarget()
	{
		$this->assertEquals('target', $this->instance->getTarget());
	}

	public function tearDown()
	{
		unset($this->instance);
	}
}