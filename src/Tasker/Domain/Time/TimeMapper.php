<?php

namespace Tasker\Domain\Time;

use Exception;

class TimeMapper
{
    protected $repository;
    protected $factory;

    public function __construct(TimeRepository $repository, TimeFactory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function save(TimeEntity $time)
    {
        if ($time->getId() !== null) {
            $this->update($time);

        } else {
            $this->insert($time);
        }
    }

    protected function insert(TimeEntity $time)
    {
        $data = array(
            'task'  => $time->getTask(),
            'start' => $time->getStart(),
            'end'   => null,
        );

        $id = $this->repository->insert($data);
        $time->setId($id);
    }

    protected function update(TimeEntity $time)
    {
        $data = array(
            'id'  => $time->getId(),
            'task'  => $time->getTask(),
            'start' => $time->getStart(),
            'end' => $time->getEnd(),
        );

        $this->repository->update($data);
    }

    public function find($id)
    {
        $data = $this->repository->find($id);
        if (!$data) {
            throw new Exception("The time '{$id}' could not be found");
        }

        return $this->factory->newEntity($data);
    }

    public function findByTask($task)
    {
        $data = $this->repository->findByTask($task);
        return $this->factory->newCollection($data);
    }

    public function findAll()
    {
        $data = $this->repository->findAll($task);
        return $this->factory->newCollection($data);
    }
}