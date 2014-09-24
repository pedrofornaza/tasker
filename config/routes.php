<?php

use Tasker\Infra\Routing\Route;

return array(
	// Default route
	new Route('/', 'get', 'Tasker\Application\Controllers\Projects::get'),

	// Projects
	new Route('/projects',     'get',  'Tasker\Application\Controllers\Projects::get'),
	new Route('/projects/:id', 'get',  'Tasker\Application\Controllers\Projects::get'),
	new Route('/projects',     'post', 'Tasker\Application\Controllers\Projects::post'),
	new Route('/projects/:id', 'post', 'Tasker\Application\Controllers\Projects::post'),

	// Tasks
	new Route('/tasks',     'get',  'Tasker\Application\Controllers\Tasks::get'),
	new Route('/tasks/:id', 'get',  'Tasker\Application\Controllers\Tasks::get'),
	new Route('/tasks',     'post', 'Tasker\Application\Controllers\Tasks::post'),
	new Route('/tasks/:id', 'post', 'Tasker\Application\Controllers\Tasks::post'),

	// Times
	new Route('/times',     'get',  'Tasker\Application\Controllers\Times::get'),
	new Route('/times/:id', 'get',  'Tasker\Application\Controllers\Times::get'),
	new Route('/times',     'post', 'Tasker\Application\Controllers\Times::post'),
	new Route('/times/:id', 'post', 'Tasker\Application\Controllers\Times::post'),
);