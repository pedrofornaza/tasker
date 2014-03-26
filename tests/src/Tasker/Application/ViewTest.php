<?php

use Tasker\Application\View;

class ViewTest extends PHPUnit_Framework_TestCase
{	
	public function testConstructorValidPath()
	{
		$path = 'tests/files/view_no_params.php';
		$instance = new View($path);

		$this->assertInstanceOf('Tasker\Application\View', $instance);
	}

	public function testConstructorInvalidPath()
	{
		$this->setExpectedException('InvalidArgumentException');

		$path = 'invalid/path';
		$instance = new View($path);
	}

	public function testRenderWithoutParams()
	{
		$path = 'tests/files/view_no_params.php';
		$instance = new View($path);

		$result = $instance->render();
		$expectedResult = 'My view body';

		$this->assertEquals($expectedResult, $result);
	}

	public function testRenderWithParams()
	{
		$path = 'tests/files/view_with_params.php';
		$instance = new View($path);

		$result = $instance->render(array('myparam' => 'myvalue'));
		$expectedResult = 'My view body with param: myvalue';

		$this->assertEquals($expectedResult, $result);
	}
}
