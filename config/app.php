<?php

use Tasker\Application\Container;
use Tasker\Application\Router;
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
	return new PDO('mysql:host=localhost;dbname=tasker', 'root', 'root');
});


$container->share('router', function() {
	$routes = include __DIR__.'/routes.php';
	return new Router($routes);
});


$container->share('project.mapper', function($container) {
	$repository = new ProjectRepository($container['database']);
	$factory = new ProjectFactory();

	return new ProjectMapper($repository, $factory);
});

$container->share('project.service', function($container) {
	return new ProjectService($container['project.mapper']);
});


$container->share('task.mapper', function($container) {
	$repository = new TaskRepository($container['database']);
	$factory = new TaskFactory();

	return new TaskMapper($repository, $factory);
});

$container->share('task.service', function($container) {
	return new TaskService($container['task.mapper']);
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