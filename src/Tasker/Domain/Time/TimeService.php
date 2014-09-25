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

    public function getByTask($task)
    {
        return $this->mapper->getByTask($task);
    }

    public function save($data)
    {
        $datetime = new DateTime();

        $entity = new TimeEntity();
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