<?php

namespace Tasker\Application\Controllers;

use Exception;
use Tasker\Infra\Container;
use Tasker\Infra\View;

class Tasks
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get($id = null)
    {
        if ($id == null) {
            return 'You should specify a Task to search.';
        }

        try {
            $taskService = $this->container['task.service'];
            $task = $taskService->get($id);

            $timeService = $this->container['time.service'];
            $times = $timeService->getByTask($id);

            $viewName = '../templates/tasks/detail.php';
            $viewParams = array(
                'task'  => $task,
                'times' => $times
            );

            $view = new View($viewName);
            return $view->render($viewParams);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function post($id = null)
    {
        try {
            $taskService = $this->container['task.service'];

            $data = array_merge($_POST['task'], array('id' => $id));
            $id = $taskService->save($data);

            header('Location: /tasks/'.$id);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}