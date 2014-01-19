<?php

namespace Tasker\Domain\Services;

use Tasker\Domain\Entities\Task as Entity;
use Tasker\Domain\Mappers\Task as Mapper;

class Task
{
	protected $mapper;

	public function __construct(Mapper $mapper)
	{
		$this->mapper = $mapper;
	}

	public function get($id)
	{
		return $this->mapper->get($id);
	}

	public function getByProject($project)
	{
		return $this->mapper->getByProject($project);
	}

	public function save($data)
	{
		$entity = new Entity();
	    $entity->setProject($data['project']);

        if ($id != null) {
	        $entity = $mapper->get($data['id']);
	    }

	    $entity->setName($data['name'])
	           ->setDescription($data['description'])
	           ->setStatus($data['status']);

	    $this->mapper->save($entity);

	    return $entity->getId();
	}
}