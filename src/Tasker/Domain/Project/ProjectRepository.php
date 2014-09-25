<?php

namespace Tasker\Domain\Project;

use Tasker\Domain\AbstractRepository;

class ProjectRepository extends AbstractRepository
{
    protected $table = 'projects';
    protected $columns = array(
        'name',
        'description',
    );
}