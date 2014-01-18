<?php

namespace Tasker\Domain\Mappers;

use PDO;
use Exception;
use Tasker\Domain\Entities\Project as Entity;

class Project
{
	protected $db;

	public function __construct(PDO $db)
	{
		$this->db = $db;
	}

    public function save(Entity $project)
    {
        if ($project->getId() !== null) {
            $this->update($project);
        } else {
            $this->insert($project);
        }
    }

    public function insert(Entity $project)
    {
    	$sql = 'INSERT INTO projects (name, description) VALUES (:name, :description)';
    	$stm = $this->db->prepare($sql);

    	$stm->bindValue(':name', $project->getName());
    	$stm->bindValue(':description', $project->getDescription());

    	if (!$stm->execute()) {
    		throw new Exception("Something went wrong inserting the project '{$project->getName()}'");
    	}

    	$id = $this->db->lastInsertId();
    	$project->setId($id);
    }

    public function update(Entity $project)
    {
    	$sql = 'UPDATE projects set name = :name, description = :description WHERE id = :id';
    	$stm = $this->db->prepare($sql);

    	$stm->bindValue(':name', $project->getName());
    	$stm->bindValue(':description', $project->getDescription());
    	$stm->bindValue(':id', $project->getId());

    	if (!$stm->execute()) {
    		throw new Exception("Something went wrong updating the project '{$project->getName()}'");
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

		$result = $stm->fetch();
		$entity = new Entity;
		$entity->setId($result['id'])
			   ->setName($result['name'])
			   ->setDescription($result['description']);

		return $entity;
	}

    public function getAll()
    {
        $sql = 'SELECT * FROM projects';
        $stm = $this->db->prepare($sql);

        if (!$stm->execute()) {
            throw new Exception('No project cant be found.');
        }

        $result = $stm->fetchAll();
        $projects = array();

        foreach ($result as $row) {
            $entity = new Entity;
            $entity->setId($row['id'])
                   ->setName($row['name'])
                   ->setDescription($row['description']);

            $projects[] = clone $entity;
        }

        return $projects;
    }
}