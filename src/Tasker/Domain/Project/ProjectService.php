<?php

namespace Tasker\Domain\Project;

class ProjectService
{
    protected $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function save($data)
    {
        $entity = new ProjectEntity();
        if ($data['id'] != null) {
            $entity = $this->repository->find($data['id']);
        }

        $entity->setName($data['name'])
               ->setDescription($data['description']);

        $this->repository->save($entity);

        return $entity->getId();
    }
}