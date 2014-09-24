<?php

use Tasker\Infra\Container;
use Tasker\Infra\Routing\Router;
use Tasker\Infra\Routing\Dispatcher\ContainerDispatcher;
use Tasker\Application\Controllers\Projects as ProjectsController;
use Tasker\Application\Controllers\Tasks as TasksController;
use Tasker\Application\Controllers\Times as TimesController;
use Tasker\Domain\Entities\Factories\Project as ProjectFactory;
use Tasker\Domain\Entities\Factories\Task as TaskFactory;
use Tasker\Domain\Entities\Factories\Time as TimeFactory;
use Tasker\Domain\Mappers\Project as ProjectMapper;
use Tasker\Domain\Mappers\Task as TaskMapper;
use Tasker\Domain\Mappers\Time as TimeMapper;
use Tasker\Domain\Repositories\Project as ProjectRepository;
use Tasker\Domain\Repositories\Task as TaskRepository;
use Tasker\Domain\Repositories\Time as TimeRepository;
use Tasker\Domain\Services\Project as ProjectService;
use Tasker\Domain\Services\Task as TaskService;
use Tasker\Domain\Services\Time as TimeService;

$container = new Container();

$container->share('database', function() {
	return new PDO('mysql:host=127.0.0.1;dbname=tasker', 'root', 'root');
});


$container->share('route.dispatcher', function() use ($container) {
	return new ContainerDispatcher($container);
});


$container->share('router', function() use ($container) {
	$dispatcher = $container['route.dispatcher'];
	$routes = include __DIR__.'/routes.php';

	return new Router($dispatcher, $routes);
});


$container->share('Tasker\Application\Controllers\Projects', function($container) {
	return new ProjectsController($container);
});

$container->share('project.mapper', function($container) {
	$repository = new ProjectRepository($container['database']);
	$factory = new ProjectFactory();

	return new ProjectMapper($repository, $factory);
});

$container->share('project.service', function($container) {
	return new ProjectService($container['project.mapper']);
});


$container->share('Tasker\Application\Controllers\Tasks', function($container) {
	return new TasksController($container);
});

$container->share('task.mapper', function($container) {
	$repository = new TaskRepository($container['database']);
	$factory = new TaskFactory();

	return new TaskMapper($repository, $factory);
});

$container->share('task.service', function($container) {
	return new TaskService($container['task.mapper']);
});


$container->share('Tasker\Application\Controllers\Times', function($container) {
	return new TimesController($container);
});

$container->share('time.mapper', function($container) {
	$repository = new TimeRepository($container['database']);
	$factory = new TimeFactory();

	return new TimeMapper($repository, $factory);
});

$container->share('time.service', function($container) {
	return new TimeService($container['time.mapper']);
});

return $container;