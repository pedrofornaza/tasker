<?php

use Tasker\Application\Route;
use Tasker\Application\Router;

class RouterTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Tasker\Application\Router;
	 */
	protected $instance;

	public function setUp()
	{
		$routes = array(
			new Route('/uri', 'method', 'target'),
		);

		$this->instance = new Router($routes);
	}

	public function testMatchWithValidCombination()
	{
		$result = $this->instance->match('/uri', 'method');

		$expectedResult = array(
			'target' => 'target',
			'params' => array('uri' => '')
		);

		$this->assertEquals($expectedResult, $result);
	}

	public function testMatchWithInvalidCombination()
	{
		$result = $this->instance->match('/uri', 'wrong_method');

		$this->assertFalse($result);
	}

	public function testMatchWithInvalidUri()
	{
		$result = $this->instance->match('/', 'method');
		$this->assertFalse($result);

		$result = $this->instance->match('', 'method');
		$this->assertFalse($result);
	}

	public function testBuildSlug()
	{
		$slug = $this->instance->buildSlug('/uri/1', array('uri' => '1'));
		$this->assertEquals('/uri/:id', $slug);

		$slug = $this->instance->buildSlug('/uri', array('uri' => ''));
		$this->assertEquals('/uri', $slug);
	}

	public function testGetParams()
	{
		$params = $this->instance->getParams(array('uri', '1'));
		$this->assertEquals(array('uri' => '1'), $params);

		$params = $this->instance->getParams(array('uri'));
		$this->assertEquals(array('uri' => ''), $params);
	}

	public function tearDown()
	{
		unset($this->instance);
	}
}