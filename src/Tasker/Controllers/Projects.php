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
        $this->mapper = new ProjectMapper($this->db);

        $method = 'getAll';
        if ($id != null) {
            $method = 'getOne';
        }

        try {
            return $this->$method($id);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    protected function getOne($id)
    {
        $project = $this->mapper->get($id);

        $taskMapper = new TaskMapper($this->db);
        $tasks = $taskMapper->getByProject($id);

        $viewParams = array(
            'project' => $project,
            'tasks'   => $tasks
        );

        $view = new View('../templates/projects/detail.php');
        return $view->render($viewParams);
    }

    protected function getAll()
    {
        $projects = $this->mapper->getAll();

        $viewParams = array('projects' => $projects);

        $view = new View('../templates/projects/list.php');
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
            return $e->getMessage();
        }
    }
}