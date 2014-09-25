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
    $projectService = $container->get('Tasker\Domain\Services\Project');
    $taskService = $container->get('Tasker\Domain\Services\Task');

    return new ProjectsController($projectService, $taskService);
});

$container->share('Tasker\Domain\Mappers\Project', function($container) {
    $repository = new ProjectRepository($container->get('PDO'));
    $factory = new ProjectFactory();

    return new ProjectMapper($repository, $factory);
});

$container->share('Tasker\Domain\Services\Project', function($container) {
    return new ProjectService($container->get('Tasker\Domain\Mappers\Project'));
});


$container->share('Tasker\Application\Controllers\Tasks', function($container) {
    $taskService = $container->get('Tasker\Domain\Services\Task');
    $timeService = $container->get('Tasker\Domain\Services\Time');

    return new TasksController($taskService, $timeService);
});

$container->share('Tasker\Domain\Mappers\Task', function($container) {
    $repository = new TaskRepository($container->get('PDO'));
    $factory = new TaskFactory();

    return new TaskMapper($repository, $factory);
});

$container->share('Tasker\Domain\Services\Task', function($container) {
    return new TaskService($container->get('Tasker\Domain\Mappers\Task'));
});


$container->share('Tasker\Application\Controllers\Times', function($container) {
    return new TimesController($container);
});

$container->share('Tasker\Domain\Mappers\Time', function($container) {
    $repository = new TimeRepository($container->get('PDO'));
    $factory = new TimeFactory();

    return new TimeMapper($repository, $factory);
});

$container->share('Tasker\Domain\Services\Time', function($container) {
    return new TimeService($container->get('Tasker\Domain\Mappers\Time'));
});

return $container;