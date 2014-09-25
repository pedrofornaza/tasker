<?php

namespace Tasker\Domain\Task;

use Exception;

class TaskMapper
{
    protected $repository;
    protected $factory;

    public function __construct(TaskRepository $repository, TaskFactory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function save(TaskEntity $task)
    {
        if ($task->getId() !== null) {
            $this->update($task);

        } else {
            $this->insert($task);
        }
    }

    public function insert(TaskEntity $task)
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

    public function update(TaskEntity $task)
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

        return $this->factory->newEntity($data);
    }

    public function getByProject($project)
    {
        $data = $this->repository->getByProject($project);
        return $this->factory->newCollection($data);
    }

    public function getAll()
    {
        $data = $this->repository->getAll();
        return $this->factory->newCollection($data);
    }
}