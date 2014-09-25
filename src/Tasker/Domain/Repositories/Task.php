<?php

namespace Tasker\Domain\Repositories;

use Exception;
use PDO;

class Task
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function insert($data)
    {
        $sql = 'INSERT INTO tasks (project, name, description, status) VALUES (:project, :name, :description, :status)';
        $stm = $this->db->prepare($sql);

        $stm->bindValue(':project',     $data['project']);
        $stm->bindValue(':name',        $data['name']);
        $stm->bindValue(':description', $data['description']);
        $stm->bindValue(':status',      $data['status']);

        if (!$stm->execute()) {
            throw new Exception("Something went wrong inserting the task.");
        }

        return $this->db->lastInsertId();
    }

    public function update($data)
    {
        $sql = 'UPDATE tasks set name = :name, description = :description, status = :status WHERE id = :id';
        $stm = $this->db->prepare($sql);

        $stm->bindValue(':name',        $data['name']);
        $stm->bindValue(':description', $data['description']);
        $stm->bindValue(':status',      $data['status']);
        $stm->bindValue(':id',          $data['id']);

        if (!$stm->execute()) {
            throw new Exception("Something went wrong updating the task.");
        }
    }

    public function get($id)
    {
        $sql = 'SELECT * FROM tasks WHERE id = :id';
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':id', $id);

        if (!$stm->execute()) {
            throw new Exception("Something went wrong selecting the task '{$id}'.");
        }

        return $stm->fetch();
    }

    public function getByProject($project)
    {
        $sql = 'SELECT * FROM tasks WHERE project = :project';
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':project', $project);
        
        if (!$stm->execute()) {
            throw new Exception("Something went wrong selecting the project '{$project}' tasks.");
        }

        return $stm->fetchAll();
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM tasks';
        $stm = $this->db->prepare($sql);

        if (!$stm->execute()) {
            throw new Exception("Something went wrong select all tasks.");
        }

        return $stm->fetchAll();
    }
}