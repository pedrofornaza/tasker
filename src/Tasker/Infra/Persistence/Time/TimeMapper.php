<?php

namespace Tasker\Infra\Persistence\Time;

use Exception;
use Tasker\Domain\Time\TimeEntity;
use Tasker\Domain\Time\TimeFactory;
use Tasker\Domain\Time\TimeRepository;

class TimeMapper implements TimeRepository
{
    protected $gateway;
    protected $factory;

    public function __construct(TimeGateway $gateway, TimeFactory $factory)
    {
        $this->gateway = $gateway;
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

        $id = $this->gateway->insert($data);
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

        $this->gateway->update($data);
    }

    public function find($id)
    {
        $data = $this->gateway->find($id);
        if (!$data) {
            throw new Exception("The time '{$id}' could not be found");
        }

        return $this->factory->newEntity($data);
    }

    public function findByTask($task)
    {
        $data = $this->gateway->findByTask($task);
        return $this->factory->newCollection($data);
    }

    public function findAll()
    {
        $data = $this->gateway->findAll($task);
        return $this->factory->newCollection($data);
    }
}