<?php

namespace Tasker\Application\Controllers;

use Exception;
use Tasker\Domain\Task\TaskService;
use Tasker\Domain\Time\TimeService;
use Tasker\Infra\View;

class Tasks
{
    protected $taskService;
    protected $timeService;

    public function __construct(TaskService $taskService, TimeService $timeService)
    {
        $this->taskService = $taskService;
        $this->timeService = $timeService;
    }

    public function getOne($id = null)
    {
        if ($id == null) {
            return 'You should specify a Task to search.';
        }

        try {
            $task = $this->taskService->get($id);
            $times = $this->timeService->getByTask($id);

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
            $data = array_merge($_POST['task'], array('id' => $id));
            $id = $this->taskService->save($data);

            header('Location: /tasks/'.$id);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}