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

    public function insert(TimeEntity $time)
    {
        $data = array(
            'task' => $time->getTask(),
            'start' => $time->getStart(),
        );

        $id = $this->repository->insert($data);
        $time->setId($id);
    }

    public function update(TimeEntity $time)
    {
        $data = array(
            'id'  => $time->getId(),
            'end' => $time->getEnd(),
        );

        $this->repository->update($data);
    }

    public function get($id)
    {
        $data = $this->repository->get($id);
        if (!$data) {
            throw new Exception("The time '{$id}' could not be found");
        }

        return $this->factory->build($data);
    }

    public function getByTask($task)
    {
        $data = $this->repository->getByTask($task);

        $times = array();
        foreach ($data as $row) {
            $times[] = $this->factory->build($row);
        }

        return $times;
    }

    public function getAll()
    {
        $data = $this->repository->getAll($task);

        $times = array();
        foreach ($data as $row) {
            $times[] = $this->factory->build($row);
        }

        return $times;
    }
}