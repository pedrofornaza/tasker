<?php

namespace Tasker\Domain\Project;

class ProjectService
{
    protected $mapper;

    public function __construct(ProjectMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function get($id)
    {
        return $this->mapper->get($id);
    }

    public function getAll()
    {
        return $this->mapper->getAll();
    }

    public function save($data)
    {
        $entity = new ProjectEntity();
        if ($data['id'] != null) {
            $entity = $this->mapper->get($data['id']);
        }

        $entity->setName($data['name'])
               ->setDescription($data['description']);

        $this->mapper->save($entity);

        return $entity->getId();
    }
}