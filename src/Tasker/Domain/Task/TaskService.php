<?php

namespace Tasker\Domain\Task;

class TaskService
{
    protected $mapper;

    public function __construct(TaskMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function get($id)
    {
        return $this->mapper->get($id);
    }

    public function getByProject($project)
    {
        return $this->mapper->getByProject($project);
    }

    public function save($data)
    {
        $entity = new TaskEntity();
        $entity->setProject($data['project']);

        if ($data['id'] != null) {
            $entity = $this->mapper->get($data['id']);
        }

        $entity->setName($data['name'])
               ->setDescription($data['description'])
               ->setStatus($data['status']);

        $this->mapper->save($entity);

        return $entity->getId();
    }
}