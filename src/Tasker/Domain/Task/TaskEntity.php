<?php

namespace Tasker\Domain\Task;

use InvalidArgumentException;

class TaskEntity
{
    protected $id;
    protected $project;
    protected $description;
    protected $status;

    protected $validStatus = array(
        'ready',
        'doing',
        'done'
    );

    public function setId($id)
    {
        if (!is_int($id) &&
            !is_numeric($id)
        ) {
            throw new InvalidArgumentException('The task id must be integer.');
        }

        $this->id = (int) $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setProject($project)
    {
        if (!is_int($project) &&
            !is_numeric($project)
        ) {
            throw new InvalidArgumentException('The task project must be integer.');
        }

        $this->project = (int) $project;
        return $this;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setName($name)
    {
        $name = trim($name);
        if ($name == '') {
            throw new InvalidArgumentException('The task name cannot be null.');
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
        if ($description == '') {
            throw new InvalidArgumentException('The task description cannot be null.');
        }

        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setStatus($status)
    {
        $status = strtolower($status);
        if (!in_array($status, $this->validStatus)) {
            throw new InvalidArgumentException('The task status must be Ready, Doing or Done.');
        }

        $this->status = $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }
}