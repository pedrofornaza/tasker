<?php

namespace Tasker\Domain\Project;

use Tasker\Domain\AbstractFactory;

class ProjectFactory extends AbstractFactory
{
    public function newEntity(array $data)
    {
        $entity = new ProjectEntity;
        $entity->setName($data['name'])
               ->setDescription($data['description']);

        if (isset($data['id'])) {
            $entity->setId($data['id']);
        }

        return $entity;
    }
}