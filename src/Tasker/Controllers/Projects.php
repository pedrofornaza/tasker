<?php

namespace Tasker\Controllers;

use Tasker\Entities\Project as ProjectEntity;
use Tasker\Mappers\Project as ProjectMapper;
use Tasker\Mappers\Task as TaskMapper;
use Tasker\View;

class Projects
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function get($id = null)
    {
        $mapper = new ProjectMapper($this->db);

        if ($id != null) {
            $project = $mapper->get($id);

            $taskMapper = new TaskMapper($this->db);
            $tasks = $taskMapper->getByProject($id);

            $viewName = '../templates/projects/detail.php';
            $viewParams = array(
                'project' => $project,
                'tasks'   => $tasks
            );
        } else {
            $projects = $mapper->getAll();

            $viewName = '../templates/projects/list.php';
            $viewParams = array('projects' => $projects);
        }

        $view = new View($viewName);
        return $view->render($viewParams);
    }

    public function post($id = null)
    {
        $mapper = new ProjectMapper($this->db);

        try {
            $entity = new ProjectEntity();
            if ($id != null) {
                $entity = $mapper->get($id);
            }

            $entity->setName($_POST['project']['name'])
                   ->setDescription($_POST['project']['description']);

            $mapper->save($entity);

            header('Location: /projects/'.$entity->getId());
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}