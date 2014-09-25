<?php

namespace Tasker\Infra\Persistence\Time;

use Tasker\Infra\Persistence\AbstractGateway;

class TimeGateway extends AbstractGateway
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