<?php

namespace Tasker\Domain;

abstract class AbstractEntity
{
    protected $id;

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
}