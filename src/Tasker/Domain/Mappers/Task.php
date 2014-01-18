<?php

namespace Tasker\Domain\Mappers;

use Exception;
use PDO;
use Tasker\Domain\Entities\Task as Entity;

class Task
{
	protected $db;

	public function __construct(PDO $db)
	{
		$this->db = $db;
	}

    public function save(Entity $task)
    {
        if ($task->getId() !== null) {
            $this->update($task);
        } else {
            $this->insert($task);
        }
    }

	public function insert(Entity $task)
    {
    	$sql = 'INSERT INTO tasks (project, name, description, status) VALUES (:project, :name, :description, :status)';
    	$stm = $this->db->prepare($sql);

        $stm->bindValue(':project', $task->getProject());
        $stm->bindValue(':name', $task->getName());
    	$stm->bindValue(':description', $task->getDescription());
    	$stm->bindValue(':status', $task->getStatus());

    	if (!$stm->execute()) {
            throw new Exception("Something went wrong inserting the task '{$task->getName()}'");
        }


    	$id = $this->db->lastInsertId();
    	$task->setId($id);
    }

    public function update(Entity $task)
    {
    	$sql = 'UPDATE tasks set name = :name, description = :description, status = :status WHERE id = :id';
    	$stm = $this->db->prepare($sql);

        $stm->bindValue(':name', $task->getName());
    	$stm->bindValue(':description', $task->getDescription());
    	$stm->bindValue(':status', $task->getStatus());
    	$stm->bindValue(':id', $task->getId());

    	if (!$stm->execute()) {
    		throw new Exception("Something went wrong updating the task '{$task->getName()}'");
    	}
    }

	public function get($id)
	{
		$sql = 'SELECT * FROM tasks WHERE id = :id';
		$stm = $this->db->prepare($sql);
		$stm->bindValue(':id', $id);

		if (!$stm->execute()) {
			throw new Exception('The task cannot be found.');
		}

		$result = $stm->fetch();
		$entity = new Entity;
		$entity->setId($result['id'])
               ->setName($result['name'])
			   ->setDescription($result['description'])
			   ->setStatus($result['status']);

		return $entity;
	}

    public function getByProject($project)
    {
        $sql = 'SELECT * FROM tasks WHERE project = :project';
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':project', $project);
        $stm->execute();

        $result = $stm->fetchAll();

        $tasks = array();

        foreach ($result as $row) {
            $entity = new Entity;
            $entity->setId($row['id'])
                   ->setName($row['name'])
                   ->setDescription($row['description'])
                   ->setStatus($row['status']);

            $tasks[] = clone $entity;
        }

        return $tasks;
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM tasks';
        $stm = $this->db->prepare($sql);
        $stm->execute();

        $result = $stm->fetchAll();

        $tasks = array();

        foreach ($result as $row) {
            $entity = new Entity;
            $entity->setId($row['id'])
                   ->setName($row['name'])
                   ->setDescription($row['description'])
                   ->setStatus($row['status']);

            $tasks[] = clone $entity;
        }

        return $tasks;
    }
}