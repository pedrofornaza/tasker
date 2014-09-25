<?php

namespace Tasker\Domain;

abstract class AbstractFactory
{
    abstract public function newEntity(array $data);

    public function newCollection(array $rows)
    {
        $entities = array();
        foreach ($rows as $row) {
            $entities[] = $this->newEntity($row);
        }

        return $entities;
    }
}