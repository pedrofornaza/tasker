<?php

namespace Tasker\Domain\Repositories;

use PDO;
use Exception;

class Project
{
	protected $db;

	public function __construct(PDO $db)
	{
		$this->db = $db;
	}

    public function insert($data)
    {
    	$sql = 'INSERT INTO projects (name, description) VALUES (:name, :description)';
    	$stm = $this->db->prepare($sql);

    	$stm->bindValue(':name',        $data['name']);
    	$stm->bindValue(':description', $data['description']);

    	if (!$stm->execute()) {
    		throw new Exception("Something went wrong inserting the project.");
    	}

    	return $this->db->lastInsertId();
    }

    public function update($data)
    {
    	$sql = 'UPDATE projects set name = :name, description = :description WHERE id = :id';
    	$stm = $this->db->prepare($sql);

    	$stm->bindValue(':name',        $data['name']);
    	$stm->bindValue(':description', $data['description']);
    	$stm->bindValue(':id',          $data['id']);

    	if (!$stm->execute()) {
    		throw new Exception("Something went wrong updating the project.");
    	}
    }

	public function get($id)
	{
		$sql = 'SELECT * FROM projects WHERE id = :id';
		$stm = $this->db->prepare($sql);

        $stm->bindValue(':id', $id);

		if (!$stm->execute()) {
			throw new Exception('The project cannot be found.');
		}

		return $stm->fetch();
	}

    public function getAll()
    {
        $sql = 'SELECT * FROM projects';
        $stm = $this->db->prepare($sql);

        if (!$stm->execute()) {
            throw new Exception('No project cant be found.');
        }

        return $stm->fetchAll();
    }
}