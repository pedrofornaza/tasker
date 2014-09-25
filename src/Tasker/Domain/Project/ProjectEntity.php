<?php

namespace Tasker\Domain\Project;

use InvalidArgumentException;
use Tasker\Domain\AbstractEntity;

class ProjectEntity extends AbstractEntity
{
    protected $name;
    protected $description;

    public function setName($name)
    {
        $name = trim($name);
        if ($name == '') {
            throw new InvalidArgumentException('The project name cannot be null.');
        }

        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $description = trim($description);
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }
}