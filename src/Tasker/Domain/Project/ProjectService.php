<?php

namespace Tasker\Domain\Project;

class ProjectService
{
    protected $mapper;

    public function __construct(ProjectMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function find($id)
    {
        return $this->mapper->find($id);
    }

    public function findAll()
    {
        return $this->mapper->findAll();
    }

    public function save($data)
    {
        $entity = new ProjectEntity();
        if ($data['id'] != null) {
            $entity = $this->mapper->find($data['id']);
        }

        $entity->setName($data['name'])
               ->setDescription($data['description']);

        $this->mapper->save($entity);

        return $entity->getId();
    }
}