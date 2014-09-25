<?php

namespace Tasker\Application\Controllers;

use Exception;
use Tasker\Domain\Project\ProjectService;
use Tasker\Domain\Task\TaskService;
use Tasker\Infra\View;

class Projects
{
    protected $projectService;
    protected $taskService;

    public function __construct(ProjectService $projectService, TaskService $taskService)
    {
        $this->projectService = $projectService;
        $this->taskService = $taskService;
    }

    public function getOne($id)
    {
        $project = $this->projectService->find($id);
        $tasks = $this->taskService->findByProject($id);

        $viewParams = array(
            'project' => $project,
            'tasks'   => $tasks
        );

        $view = new View('../templates/projects/detail.php');
        return $view->render($viewParams);
    }

    public function getAll()
    {
        $projects = $this->projectService->findAll();

        $viewParams = array('projects' => $projects);

        $view = new View('../templates/projects/list.php');
        return $view->render($viewParams);
    }

    public function post($id = null)
    {
        try {
            $data = array_merge($_POST['project'], array('id' => $id));
            $id = $this->projectService->save($data);

            header('Location: /projects/'.$id);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}