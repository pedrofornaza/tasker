<?php

namespace Tasker\Domain\Time;

use DateTime;

class TimeService
{
    protected $mapper;

    public function __construct(TimeMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function findByTask($task)
    {
        return $this->mapper->findByTask($task);
    }

    public function save($data)
    {
        $datetime = new DateTime();

        $entity = new TimeEntity();
        $entity->setStart($datetime->format('Y-m-d h:i:s'));

        if ($data['type'] == 'end') {
            $entity = $this->mapper->find($data['id']);
            $entity->setEnd($datetime->format('Y-m-d h:i:s'));
        }

        $entity->setTask($data['task']);

        $this->mapper->save($entity);

        return $entity->getId();
    }
}