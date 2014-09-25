<?php

namespace Tasker\Domain\Entities\Factories;

use Tasker\Domain\Entities\Project as Entity;

class Project implements FactoryInterface
{
    public function build($data)
    {
        $entity = new Entity;
        $entity->setId($data['id'])
               ->setName($data['name'])
               ->setDescription($data['description']);

        return $entity;
    }
}