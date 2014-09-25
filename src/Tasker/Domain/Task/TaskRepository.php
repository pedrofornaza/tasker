<?php

namespace Tasker\Domain\Task;

interface TaskRepository
{
    public function save(TaskEntity $task);
    public function find($id);
    public function findByProject($project);
    public function findAll();
}