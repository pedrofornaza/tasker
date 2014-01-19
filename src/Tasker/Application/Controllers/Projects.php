<?php

namespace Tasker\Application\Controllers;

use Exception;
use Tasker\Application\Container;
use Tasker\Application\View;
use Tasker\Domain\Entities\Project as ProjectEntity;
use Tasker\Domain\Mappers\Project as ProjectMapper;
use Tasker\Domain\Mappers\Task as TaskMapper;

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
        $mapper = $this->container['project.mapper'];
        $project = $mapper->get($id);

        $taskMapper = $this->container['task.mapper'];
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
        $mapper = $this->container['project.mapper'];
        $projects = $mapper->getAll();

        $viewParams = array('projects' => $projects);

        $view = new View('../templates/projects/list.php');
        return $view->render($viewParams);
    }

    public function post($id = null)
    {
        $mapper = $this->container['project.mapper'];

        try {
            $entity = new ProjectEntity();
            if ($id != null) {
                $entity = $mapper->get($id);
            }

            $entity->setName($_POST['project']['name'])
                   ->setDescription($_POST['project']['description']);

            $mapper->save($entity);

            header('Location: /projects/'.$entity->getId());

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}