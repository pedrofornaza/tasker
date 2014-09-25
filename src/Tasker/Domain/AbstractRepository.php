<?php

namespace Tasker\Domain;

use Exception;
use PDO;

abstract class AbstractRepository
{
    protected $db;
    protected $table;
    protected $columns = array();

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function insert(array $data)
    {
        $columns = implode(', ', $this->columns);

        $bindNames = array_map(function($value) {
            return ':' . $value;
        }, $this->columns);
        $bindNames = implode(', ', $bindNames);

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$bindNames})";
        $stm = $this->db->prepare($sql);

        foreach ($this->columns as $column) {
            $bindName = ':' . $column;
            $value = $data[$column];

            $stm->bindValue($bindName, $value);
        }

        if ( ! $stm->execute()) {
            throw new Exception("Something went wrong inserting.");
        }

        return $this->db->lastInsertId();
    }

    public function update(array $data)
    {
        if ( ! isset($data['id'])) {
            throw new Exception('Cannot update without an ID.');
        }

        $set = array_map(function(&$column) {
            return "{$column} = :{$column}";
        }, $this->columns);
        $set = implode(', ', $set);

        $sql = "UPDATE {$this->table} SET {$set} WHERE id = :id";
        $stm = $this->db->prepare($sql);

        foreach ($this->columns as $column) {
            $bindName = ':' . $column;
            $value = $data[$column];

            $stm->bindValue($bindName, $value);
        }

        $stm->bindValue(':id', $data['id']);

        if ( ! $stm->execute()) {
            throw new Exception("Something went wrong updating.");
        }
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':id', $id);

        if ( ! $stm->execute()) {
            throw new Exception("Something went wrong selecting the ID '{$id}'.");
        }

        return $stm->fetch();
    }

    public function findBy(array $data)
    {
        $columns = array_keys($data);
        if (array_diff($columns, $this->columns)) {
            throw new Exception("Trying to filter using columns that is not present in '{$this->table}'");
        }

        $where = array_map(function($column) {
            return "{$column} = :{$column}";
        }, $columns);
        $where = implode(' AND ', $where);

        $sql = "SELECT * FROM {$this->table} WHERE {$where}";
        $stm = $this->db->prepare($sql);

        foreach ($columns as $column) {
            $bindName = ':' . $column;
            $value = $data[$column];

            $stm->bindValue($bindName, $value);
        }

        if ( ! $stm->execute()) {
            throw new Exception("Something went wrong selecting the registries.");
        }

        return $stm->fetchAll();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stm = $this->db->prepare($sql);

        if ( ! $stm->execute()) {
            throw new Exception("Something went wrong selecting all registries.");
        }

        return $stm->fetchAll();
    }
}