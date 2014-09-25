<?php

namespace Tasker\Domain\Task;

use Tasker\Domain\FactoryInterface;

class TaskFactory implements FactoryInterface
{
    public function build($data)
    {
        $entity = new TaskEntity;
        $entity->setId($data['id'])
               ->setProject($data['project'])
               ->setName($data['name'])
               ->setDescription($data['description'])
               ->setStatus($data['status']);

        return $entity;
    }
}