<?php

namespace Tasker\Controllers;

use Tasker\Entities\Task as TaskEntity;
use Tasker\Mappers\Task as TaskMapper;
use Tasker\Mappers\Time as TimeMapper;
use Tasker\View;

class Tasks
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function get($id = null)
    {
        $mapper = new TaskMapper($this->db);

        if ($id == null) {
            echo 'You should specify a Task to search';
            exit;
        }

        $task = $mapper->get($id);

        $timeMapper = new TimeMapper($this->db);
        $times = $timeMapper->getByTask($id);

        $viewName = '../templates/tasks/detail.php';
        $viewParams = array(
            'task' => $task,
            'times'   => $times
        );

        $view = new View($viewName);
        return $view->render($viewParams);
    }

    public function post($id = null)
    {
        $mapper = new TaskMapper($this->db);

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
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}