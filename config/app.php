<?php

use Tasker\Infra\Container;
use Tasker\Infra\Routing\Router;
use Tasker\Infra\Routing\Dispatcher\ContainerDispatcher;
use Tasker\Application\Controllers\Projects as ProjectsController;
use Tasker\Application\Controllers\Tasks as TasksController;
use Tasker\Application\Controllers\Times as TimesController;
use Tasker\Domain\Project\ProjectFactory;
use Tasker\Domain\Task\TaskFactory;
use Tasker\Domain\Time\TimeFactory;
use Tasker\Domain\Project\ProjectMapper;
use Tasker\Domain\Task\TaskMapper;
use Tasker\Domain\Time\TimeMapper;
use Tasker\Domain\Project\ProjectRepository;
use Tasker\Domain\Task\TaskRepository;
use Tasker\Domain\Time\TimeRepository;
use Tasker\Domain\Project\ProjectService;
use Tasker\Domain\Task\TaskService;
use Tasker\Domain\Time\TimeService;

$container = new Container();

$container->share('PDO', function() {
    return new PDO('mysql:host=127.0.0.1;dbname=tasker', 'root', 'root');
});


$container->share('Tasker\Infra\Routing\Dispatcher\ContainerDispatcher', function() use ($container) {
    return new ContainerDispatcher($container);
});


$container->share('Tasker\Infra\Routing\Router', function() use ($container) {
    $dispatcher = $container->get('Tasker\Infra\Routing\Dispatcher\ContainerDispatcher');
    $routes = include __DIR__.'/routes.php';

    return new Router($dispatcher, $routes);
});


$container->share('Tasker\Application\Controllers\Projects', function($container) {
    $projectService = $container->get('Tasker\Domain\Project\ProjectService');
    $taskService = $container->get('Tasker\Domain\Task\TaskService');

    return new ProjectsController($projectService, $taskService);
});

$container->share('Tasker\Domain\Project\ProjectMapper', function($container) {
    $repository = new ProjectRepository($container->get('PDO'));
    $factory = new ProjectFactory();

    return new ProjectMapper($repository, $factory);
});

$container->share('Tasker\Domain\Project\ProjectService', function($container) {
    return new ProjectService($container->get('Tasker\Domain\Project\ProjectMapper'));
});


$container->share('Tasker\Application\Controllers\Tasks', function($container) {
    $taskService = $container->get('Tasker\Domain\Task\TaskService');
    $timeService = $container->get('Tasker\Domain\Time\TimeService');

    return new TasksController($taskService, $timeService);
});

$container->share('Tasker\Domain\Task\TaskMapper', function($container) {
    $repository = new TaskRepository($container->get('PDO'));
    $factory = new TaskFactory();

    return new TaskMapper($repository, $factory);
});

$container->share('Tasker\Domain\Task\TaskService', function($container) {
    return new TaskService($container->get('Tasker\Domain\Task\TaskMapper'));
});


$container->share('Tasker\Application\Controllers\Times', function($container) {
    $timeService = $container->get('Tasker\Domain\Time\TimeService');

    return new TimesController($timeService);
});

$container->share('Tasker\Domain\Time\TimeMapper', function($container) {
    $repository = new TimeRepository($container->get('PDO'));
    $factory = new TimeFactory();

    return new TimeMapper($repository, $factory);
});

$container->share('Tasker\Domain\Time\TimeService', function($container) {
    return new TimeService($container->get('Tasker\Domain\Time\TimeMapper'));
});

return $container;