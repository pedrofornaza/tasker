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
            'project'     => $task->getProject(),
            'name'        => $task->getName(),
            'description' => $task->getDescription(),
            'status'      => $task->getStatus(),
        );

        $this->repository->update($data);
    }

    public function find($id)
    {
        $data = $this->repository->find($id);
        if (!$data) {
            throw new Exception("The task '{$id}' could not be found.");
        }

        return $this->factory->newEntity($data);
    }

    public function findByProject($project)
    {
        $data = $this->repository->findByProject($project);
        return $this->factory->newCollection($data);
    }

    public function findAll()
    {
        $data = $this->repository->findAll();
        return $this->factory->newCollection($data);
    }
}