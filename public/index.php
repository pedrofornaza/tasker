<?php

require '../vendor/autoload.php';

use Exception;
use Tasker\Application\Application;

try {
	$container = include '../config/app.php';

	$app = new Application($container);
	$app->run($_SERVER);
} catch (Exception $e) {
	echo $e->getMessage();
}