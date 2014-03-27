<?php

use Tasker\Application\Container;

class ContainerTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Tasker\Application\Container;
	 */
	protected $instance;

	public function setUp()
	{
		$this->instance = new Container();
	}

	public function testOffsetSetAndOffsetGet()
	{
		$value = 'myvalue';
		$this->instance['myprop'] = $value;

		$this->assertEquals($value, $this->instance['myprop']);
	}

	public function testOffsetExistsWithOffsetSet()
	{
		$this->instance['myprop'] = 'myvalue';

		$this->assertTrue(isset($this->instance['myprop']));
	}

	public function testOffsetUnsetWithOffsetSet()
	{
		$value = 'myvalue';
		$this->instance['myprop'] = $value;

		unset($this->instance['myprop']);

		/** Checks if myprop exists **/
		$this->assertFalse(isset($this->instance['myprop']));

		/** If myprop dont exist, must return null **/
		$this->assertNull($this->instance['myprop']);
	}

	public function testShareAndOffsetGet()
	{
		$lambda = function() { return 'myvalue'; };
		$this->instance->share('myprop', $lambda);

		$this->assertEquals('myvalue', $this->instance['myprop']);
	}

	public function testOffsetExistsWithShare()
	{
		$lambda = function() { echo 'testing share'; };
		$this->instance->share('myprop', $lambda);

		$this->assertTrue(isset($this->instance['myprop']));
	}

	public function testOffsetUnsetWithShare()
	{
		$lambda = function() { return 'my value'; };
		$this->instance->share('myprop', $lambda);

		unset($this->instance['myprop']);

		/** Checks if myprop exists **/
		$this->assertFalse(isset($this->instance['myprop']));

		/** If myprop dont exist, must return null **/
		$this->assertNull($this->instance['myprop']);
	}

	public function tearDown()
	{
		unset($this->instance);
	}
}