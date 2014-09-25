<?php

use Tasker\Infra\Routing\Route;

return array(
	// Default route
	new Route('/', 'get', 'Tasker\Application\Controllers\Projects::getAll'),

	// Projects
	new Route('/projects',     'get',  'Tasker\Application\Controllers\Projects::getAll'),
	new Route('/projects/:id', 'get',  'Tasker\Application\Controllers\Projects::getOne'),
	new Route('/projects',     'post', 'Tasker\Application\Controllers\Projects::post'),
	new Route('/projects/:id', 'post', 'Tasker\Application\Controllers\Projects::post'),

	// Tasks
	new Route('/tasks/:id', 'get',  'Tasker\Application\Controllers\Tasks::getOne'),
	new Route('/tasks',     'post', 'Tasker\Application\Controllers\Tasks::post'),
	new Route('/tasks/:id', 'post', 'Tasker\Application\Controllers\Tasks::post'),

	// Times
	new Route('/times',     'post', 'Tasker\Application\Controllers\Times::post'),
	new Route('/times/:id', 'post', 'Tasker\Application\Controllers\Times::post'),
);