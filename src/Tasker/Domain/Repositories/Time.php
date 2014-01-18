<?php

namespace Tasker\Domain\Repositories;

use Exception;
use PDO;

class Time
{
	protected $db;

	public function __construct(PDO $db)
	{
		$this->db = $db;
	}

	public function insert($data)
    {
    	$sql = 'INSERT INTO times (task, start) VALUES (:task, :start)';
    	$stm = $this->db->prepare($sql);

    	$stm->bindValue(':task',  $data['task']);
        $stm->bindValue(':start', $data['start']);

        if (!$stm->execute()) {
            throw new Exception("Something went wrong inserting the time.");
        }

        return $this->db->lastInsertId();
    }

    public function update($data)
    {
        $sql = 'UPDATE times set end = :end WHERE id = :id';
        $stm = $this->db->prepare($sql);

    	$stm->bindValue(':end', $data['end']);
    	$stm->bindValue(':id',  $data['id']);

    	if (!$stm->execute()) {
    		throw new Exception("Something went wrong updating the time.");
    	}
    }

	public function get($id)
	{
		$sql = 'SELECT * FROM times WHERE id = :id';
		$stm = $this->db->prepare($sql);
		$stm->bindValue(':id', $id);
        
        if (!$stm->execute()) {
            throw new Exception("Something went wrong selecting the '{$id}' registry.");
        }

        return $stm->fetch();
	}

    public function getByTask($task)
    {
        $sql = 'SELECT * FROM times WHERE task = :task';
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':task', $task);

        if (!$stm->execute()) {
            throw new Exception("Something went wrong selecting the task '{$task}' times registries.");
        }

        return $stm->fetchAll();
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM times';
        $stm = $this->db->prepare($sql);
        
        if (!$stm->execute()) {
            throw new Exception("Something went wrong selecting all the times registries.");
        }

        return $stm->fetchAll();
    }
}