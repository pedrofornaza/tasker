<?php

namespace Tasker\Domain\Task;

class TaskService
{
    protected $mapper;

    public function __construct(TaskMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function find($id)
    {
        return $this->mapper->find($id);
    }

    public function findByProject($project)
    {
        return $this->mapper->findByProject($project);
    }

    public function save($data)
    {
        $entity = new TaskEntity();
        $entity->setProject($data['project']);

        if ($data['id'] != null) {
            $entity = $this->mapper->find($data['id']);
        }

        $entity->setName($data['name'])
               ->setDescription($data['description'])
               ->setStatus($data['status']);

        $this->mapper->save($entity);

        return $entity->getId();
    }
}