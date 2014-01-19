<?php

namespace Tasker\Application\Controllers;

use Exception;
use Tasker\Application\Container;
use Tasker\Application\View;

class Projects
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get($id = null)
    {
        $method = 'getAll';
        if ($id != null) {
            $method = 'getOne';
        }

        try {
            return $this->$method($id);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    protected function getOne($id)
    {
        $projectService = $this->container['project.service'];
        $project = $projectService->get($id);

        $taskService = $this->container['task.service'];
        $tasks = $taskService->getByProject($id);

        $viewParams = array(
            'project' => $project,
            'tasks'   => $tasks
        );

        $view = new View('../templates/projects/detail.php');
        return $view->render($viewParams);
    }

    protected function getAll()
    {
        $projectService = $this->container['project.service'];
        $projects = $projectService->getAll();

        $viewParams = array('projects' => $projects);

        $view = new View('../templates/projects/list.php');
        return $view->render($viewParams);
    }

    public function post($id = null)
    {
        try {
            $projectService = $this->container['project.service'];

            $data = array_merge($_POST['project'], array('id' => $id));
            $id = $projectService->save($data);

            header('Location: /projects/'.$id);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}