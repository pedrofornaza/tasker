<?php

namespace Tasker\Mappers;

use Tasker\Entities\Time as Entity;

class Time
{
	protected $db;

	public function __construct(\PDO $db)
	{
		$this->db = $db;
	}

    public function save(Entity $time)
    {
        if ($time->getId() !== null) {
            $this->update($time);
        } else {
            $this->insert($time);
        }
    }

	public function insert(Entity $time)
    {
    	$sql = 'INSERT INTO times (task, start) VALUES (:task, :start)';
    	$stm = $this->db->prepare($sql);

    	$stm->bindValue(':task', $time->getTask());
        $stm->bindValue(':start', $time->getStart());
        var_dump($time->getStart());

        if (!$stm->execute()) {
            throw new \Exception("Something went wrong inserting the time");
        }

        $id = $this->db->lastInsertId();
        $time->setId($id);
    }

    public function update(Entity $time)
    {
        $sql = 'UPDATE times set end = :end WHERE id = :id';
        $stm = $this->db->prepare($sql);

    	$stm->bindValue(':end', $time->getEnd());
    	$stm->bindValue(':id', $time->getId());

    	if (!$stm->execute()) {
    		throw new \Exception("Something went wrong updating the time");
    	}
    }

	public function getByTask($task)
	{
		$sql = 'SELECT * FROM times WHERE task = :task';
		$stm = $this->db->prepare($sql);
		$stm->bindValue(':task', $task);
        $stm->execute();

        $result = $stm->fetchAll();

        $times = array();

        foreach ($result as $row) {
            $entity = new Entity;
            $entity->setId($row['id'])
                   ->setTask($row['task'])
                   ->setStart($row['start'])
                   ->setEnd($row['end']);

            $times[] = clone $entity;
        }

        return $times;
	}

    public function getAll()
    {
        $sql = 'SELECT * FROM times';
        $stm = $this->db->prepare($sql);
        $stm->execute();

        $result = $stm->fetchAll();

        $times = array();

        foreach ($result as $row) {
            $entity = new Entity;
            $entity->setId($row['id'])
                   ->setTask($row['task'])
                   ->setStart($row['start'])
                   ->setEnd($row['end']);

            $times[] = clone $entity;
        }

        return $times;
    }
}