<?php

namespace Tasker\Domain\Entities\Factories;

use Tasker\Domain\Entities\Time as Entity;

class Time implements FactoryInterface
{
    public function build($data)
    {
        $entity = new Entity;
        $entity->setId($data['id'])
               ->setTask($data['task'])
               ->setStart($data['start'])
               ->setEnd($data['end']);

        return $entity;
    }
}