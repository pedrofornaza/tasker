<?php

include '../vendor/autoload.php';

use Tasker\Application as App;

try {
	$db = new PDO('mysql:host=localhost;dbname=tasker', '', '');

	$app = new App($db);
	$app->run($_SERVER);
} catch (\Exception $e) {
	echo $e->getMessage();
}