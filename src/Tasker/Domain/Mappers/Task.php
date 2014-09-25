<?php

namespace Tasker\Domain\Mappers;

use Exception;
use Tasker\Domain\Entities\Task as Entity;
use Tasker\Domain\Entities\Factories\Task as Factory;
use Tasker\Domain\Repositories\Task as Repository;

class Task
{
    protected $repository;
    protected $factory;

    public function __construct(Repository $repository, Factory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function save(Entity $task)
    {
        if ($task->getId() !== null) {
            $this->update($task);

        } else {
            $this->insert($task);
        }
    }

    public function insert(Entity $task)
    {
        $data = array(
            'project'     => $task->getProject(),
            'name'        => $task->getName(),
            'description' => $task->getDescription(),
            'status'      => $task->getStatus(),
        );

        $id = $this->repository->insert($data);
        $task->setId($id);
    }

    public function update(Entity $task)
    {
        $data = array(
            'id'          => $task->getId(),
            'name'        => $task->getName(),
            'description' => $task->getDescription(),
            'status'      => $task->getStatus(),
        );

        $this->repository->update($data);
    }

    public function get($id)
    {
        $data = $this->repository->get($id);
        if (!$data) {
            throw new Exception("The task '{$id}' could not be found.");
        }

        return $this->factory->build($data);
    }

    public function getByProject($project)
    {
        $data = $this->repository->getByProject($project);

        $tasks = array();
        foreach ($data as $row) {
            $tasks[] = $this->factory->build($row);
        }

        return $tasks;
    }

    public function getAll()
    {
        $data = $this->repository->getAll();

        $tasks = array();
        foreach ($data as $row) {
            $tasks[] = $this->factory->build($row);
        }

        return $tasks;
    }
}