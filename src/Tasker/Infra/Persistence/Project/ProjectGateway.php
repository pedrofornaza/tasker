<?php

namespace Tasker\Infra\Persistence\Project;

use Tasker\Infra\Persistence\AbstractGateway;

class ProjectGateway extends AbstractGateway
{
    protected $table = 'projects';
    protected $columns = array(
        'name',
        'description',
    );
}