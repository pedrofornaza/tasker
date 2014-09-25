<?php

namespace Tasker\Domain\Services;

use DateTime;
use Tasker\Domain\Entities\Time as Entity;
use Tasker\Domain\Mappers\Time as Mapper;

class Time
{
    protected $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function getByTask($task)
    {
        return $this->mapper->getByTask($task);
    }

    public function save($data)
    {
        $datetime = new DateTime();

        $entity = new Entity();
        $entity->setStart($datetime->format('Y-m-d h:i:s'));

        if ($data['type'] == 'end') {
            $entity = $this->mapper->get($data['id']);
            $entity->setEnd($datetime->format('Y-m-d h:i:s'));
        }

        $entity->setTask($data['task']);

        $this->mapper->save($entity);

        return $entity->getId();
    }
}