<?php

namespace Tasker\Domain\Mappers;

use Exception;
use Tasker\Domain\Entities\Time as Entity;
use Tasker\Domain\Entities\Factories\Time as Factory;
use Tasker\Domain\Repositories\Time as Repository;

class Time
{
    protected $repository;
    protected $factory;

    public function __construct(Repository $repository, Factory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function save(Entity $time)
    {
        if ($time->getId() !== null) {
            $this->update($time);

        } else {
            $this->insert($time);
        }
    }

    public function insert(Entity $time)
    {
        $data = array(
            'task' => $time->getTask(),
            'start' => $time->getStart(),
        );

        $id = $this->repository->insert($data);
        $time->setId($id);
    }

    public function update(Entity $time)
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