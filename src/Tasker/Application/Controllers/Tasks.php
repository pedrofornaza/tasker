<?php

namespace Tasker\Application\Controllers;

use Exception;
use Tasker\Application\Container;
use Tasker\Application\View;
use Tasker\Domain\Entities\Task as TaskEntity;
use Tasker\Domain\Mappers\Task as TaskMapper;
use Tasker\Domain\Mappers\Time as TimeMapper;

class Tasks
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get($id = null)
    {
        $mapper = $this->container['task.mapper'];

        if ($id == null) {
            return 'You should specify a Task to search.';
        }

        try {
            $task = $mapper->get($id);

            $timeMapper = $this->container['time.mapper'];
            $times = $timeMapper->getByTask($id);

            $viewName = '../templates/tasks/detail.php';
            $viewParams = array(
                'task' => $task,
                'times'   => $times
            );

            $view = new View($viewName);
            return $view->render($viewParams);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function post($id = null)
    {
        $mapper = $this->container['task.mapper'];

        try {
            $entity = new TaskEntity();
            if ($id != null) {
                $entity = $mapper->get($id);
            }

            $entity->setProject($_POST['task']['project'])
                   ->setName($_POST['task']['name'])
                   ->setDescription($_POST['task']['description'])
                   ->setStatus($_POST['task']['status']);

            $mapper->save($entity);

            header('Location: /tasks/'.$entity->getId());

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}