<?php

namespace Tasker\Domain\Task;

use Tasker\Domain\AbstractFactory;

class TaskFactory extends AbstractFactory
{
    public function newEntity(array $data)
    {
        $entity = new TaskEntity;
        $entity->setProject($data['project'])
               ->setName($data['name'])
               ->setDescription($data['description'])
               ->setStatus($data['status']);

        if (isset($data['id'])) {
            $entity->setId($data['id']);
        }

        return $entity;
    }
}