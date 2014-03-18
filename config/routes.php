<?php

use Tasker\Application\Route;

return array(
	// Default route
	new Route('/', 'get', 'Tasker\Application\Controllers\Projects'),

	// Projects
	new Route('/projects',     'get',  'Tasker\Application\Controllers\Projects'),
	new Route('/projects/:id', 'get',  'Tasker\Application\Controllers\Projects'),
	new Route('/projects',     'post', 'Tasker\Application\Controllers\Projects'),

	// Tasks
	new Route('/tasks',     'get',  'Tasker\Application\Controllers\Tasks'),
	new Route('/tasks/:id', 'get',  'Tasker\Application\Controllers\Tasks'),
	new Route('/tasks',     'post', 'Tasker\Application\Controllers\Tasks'),

	// Times
	new Route('/times',     'get',  'Tasker\Application\Controllers\Times'),
	new Route('/times/:id', 'get',  'Tasker\Application\Controllers\Times'),
	new Route('/times',     'post', 'Tasker\Application\Controllers\Times'),
	new Route('/times/:id', 'post', 'Tasker\Application\Controllers\Times'),
);