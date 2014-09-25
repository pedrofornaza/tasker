<?php

namespace Tasker\Domain\Project;

use Tasker\Domain\FactoryInterface;

class ProjectFactory implements FactoryInterface
{
    public function build($data)
    {
        $entity = new ProjectEntity;
        $entity->setId($data['id'])
               ->setName($data['name'])
               ->setDescription($data['description']);

        return $entity;
    }
}