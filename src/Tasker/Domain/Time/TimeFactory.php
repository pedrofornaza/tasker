<?php

namespace Tasker\Domain\Time;

use Tasker\Domain\FactoryInterface;

class TimeFactory implements FactoryInterface
{
    public function build($data)
    {
        $entity = new TimeEntity;
        $entity->setId($data['id'])
               ->setTask($data['task'])
               ->setStart($data['start'])
               ->setEnd($data['end']);

        return $entity;
    }
}