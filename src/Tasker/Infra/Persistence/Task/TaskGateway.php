<?php

namespace Tasker\Infra\Persistence\Task;

use Tasker\Infra\Persistence\AbstractGateway;

class TaskGateway extends AbstractGateway
{
    protected $table = 'tasks';
    protected $columns = array(
        'project',
        'name',
        'description',
        'status',
    );

    public function findByProject($project)
    {
        $data = array(
            'project' => $project
        );

        return $this->findBy($data);
    }
}