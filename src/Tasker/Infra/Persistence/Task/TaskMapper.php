<?php

namespace Tasker\Infra\Persistence\Task;

use Exception;
use Tasker\Domain\Task\TaskEntity;
use Tasker\Domain\Task\TaskFactory;
use Tasker\Domain\Task\TaskRepository;

class TaskMapper implements TaskRepository
{
    protected $gateway;
    protected $factory;

    public function __construct(TaskGateway $gateway, TaskFactory $factory)
    {
        $this->gateway = $gateway;
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

    protected function insert(TaskEntity $task)
    {
        $data = array(
            'project'     => $task->getProject(),
            'name'        => $task->getName(),
            'description' => $task->getDescription(),
            'status'      => $task->getStatus(),
        );

        $id = $this->gateway->insert($data);
        $task->setId($id);
    }

    protected function update(TaskEntity $task)
    {
        $data = array(
            'id'          => $task->getId(),
            'project'     => $task->getProject(),
            'name'        => $task->getName(),
            'description' => $task->getDescription(),
            'status'      => $task->getStatus(),
        );

        $this->gateway->update($data);
    }

    public function find($id)
    {
        $data = $this->gateway->find($id);
        if (!$data) {
            throw new Exception("The task '{$id}' could not be found.");
        }

        return $this->factory->newEntity($data);
    }

    public function findByProject($project)
    {
        $data = $this->gateway->findByProject($project);
        return $this->factory->newCollection($data);
    }

    public function findAll()
    {
        $data = $this->gateway->findAll();
        return $this->factory->newCollection($data);
    }
}