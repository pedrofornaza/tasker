<?php

namespace Tasker\Domain\Task;

class TaskService
{
    protected $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function findByProject($project)
    {
        return $this->repository->findByProject($project);
    }

    public function save($data)
    {
        $entity = new TaskEntity();
        $entity->setProject($data['project']);

        if ($data['id'] != null) {
            $entity = $this->repository->find($data['id']);
        }

        $entity->setName($data['name'])
               ->setDescription($data['description'])
               ->setStatus($data['status']);

        $this->repository->save($entity);

        return $entity->getId();
    }
}