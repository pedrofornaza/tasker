<?php

namespace Tasker\Domain\Time;

use Tasker\Domain\AbstractFactory;

class TimeFactory extends AbstractFactory
{
    public function newEntity(array $data)
    {
        $entity = new TimeEntity;
        $entity->setTask($data['task'])
               ->setStart($data['start'])
               ->setEnd($data['end']);

        if (isset($data['id'])) {
            $entity->setId($data['id']);
        }

        return $entity;
    }
}