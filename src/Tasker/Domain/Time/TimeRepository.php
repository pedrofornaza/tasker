<?php

namespace Tasker\Domain\Time;

interface TimeRepository
{
    public function save(TimeEntity $time);
    public function find($id);
    public function findByTask($task);
    public function findAll();
}