<?php

namespace Tasker\Domain\Time;

use Tasker\Domain\AbstractRepository;

class TimeRepository extends AbstractRepository
{
    protected $table = 'times';
    protected $columns = array(
        'task',
        'start',
        'end',
    );

    public function findByTask($task)
    {
        $data = array(
            'task' => $task
        );

        return $this->findBy($data);
    }
}