<?php

namespace Tasker\Domain\Task;

use Tasker\Domain\AbstractRepository;

class TaskRepository extends AbstractRepository
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