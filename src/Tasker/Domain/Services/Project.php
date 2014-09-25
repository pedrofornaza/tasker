<?php

namespace Tasker\Domain\Services;

use Tasker\Domain\Entities\Project as Entity;
use Tasker\Domain\Mappers\Project as Mapper;

class Project
{
    protected $mapper;

    public function __construct(Mapper $mapper)
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
        $entity = new Entity();
        if ($data['id'] != null) {
            $entity = $this->mapper->get($data['id']);
        }

        $entity->setName($data['name'])
               ->setDescription($data['description']);

        $this->mapper->save($entity);

        return $entity->getId();
    }
}