<?php

namespace Tasker\Domain\Entities\Factories;

use Tasker\Domain\Entities\Task as Entity;

class Task implements FactoryInterface
{
    public function build($data)
    {
        $entity = new Entity;
        $entity->setId($data['id'])
               ->setProject($data['project'])
               ->setName($data['name'])
               ->setDescription($data['description'])
               ->setStatus($data['status']);

        return $entity;
    }
}