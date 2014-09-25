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
use Tasker\Domain\Project\ProjectService;
use Tasker\Domain\Task\TaskService;
use Tasker\Domain\Time\TimeService;
use Tasker\Infra\Persistence\Project\ProjectGateway;
use Tasker\Infra\Persistence\Project\ProjectMapper;
use Tasker\Infra\Persistence\Task\TaskGateway;
use Tasker\Infra\Persistence\Task\TaskMapper;
use Tasker\Infra\Persistence\Time\TimeGateway;
use Tasker\Infra\Persistence\Time\TimeMapper;

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

$container->share('Tasker\Infra\Persistence\Project\ProjectMapper', function($container) {
    $gateway = new ProjectGateway($container->get('PDO'));
    $factory = new ProjectFactory();

    return new ProjectMapper($gateway, $factory);
});

$container->share('Tasker\Domain\Project\ProjectService', function($container) {
    return new ProjectService($container->get('Tasker\Infra\Persistence\Project\ProjectMapper'));
});


$container->share('Tasker\Application\Controllers\Tasks', function($container) {
    $taskService = $container->get('Tasker\Domain\Task\TaskService');
    $timeService = $container->get('Tasker\Domain\Time\TimeService');

    return new TasksController($taskService, $timeService);
});

$container->share('Tasker\Infra\Persistence\Task\TaskMapper', function($container) {
    $gateway = new TaskGateway($container->get('PDO'));
    $factory = new TaskFactory();

    return new TaskMapper($gateway, $factory);
});

$container->share('Tasker\Domain\Task\TaskService', function($container) {
    return new TaskService($container->get('Tasker\Infra\Persistence\Task\TaskMapper'));
});


$container->share('Tasker\Application\Controllers\Times', function($container) {
    $timeService = $container->get('Tasker\Domain\Time\TimeService');

    return new TimesController($timeService);
});

$container->share('Tasker\Infra\Persistence\Time\TimeMapper', function($container) {
    $gateway = new TimeGateway($container->get('PDO'));
    $factory = new TimeFactory();

    return new TimeMapper($gateway, $factory);
});

$container->share('Tasker\Domain\Time\TimeService', function($container) {
    return new TimeService($container->get('Tasker\Infra\Persistence\Time\TimeMapper'));
});

return $container;