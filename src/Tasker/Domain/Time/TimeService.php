<?php

namespace Tasker\Domain\Time;

use DateTime;

class TimeService
{
    protected $repository;

    public function __construct(TimeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findByTask($task)
    {
        return $this->repository->findByTask($task);
    }

    public function save($data)
    {
        $datetime = new DateTime();

        $entity = new TimeEntity();
        $entity->setStart($datetime->format('Y-m-d h:i:s'));

        if ($data['type'] == 'end') {
            $entity = $this->repository->find($data['id']);
            $entity->setEnd($datetime->format('Y-m-d h:i:s'));
        }

        $entity->setTask($data['task']);

        $this->repository->save($entity);

        return $entity->getId();
    }
}