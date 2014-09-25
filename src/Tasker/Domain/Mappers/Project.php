<?php

namespace Tasker\Domain\Mappers;

use Exception;
use Tasker\Domain\Entities\Project as Entity;
use Tasker\Domain\Entities\Factories\Project as Factory;
use Tasker\Domain\Repositories\Project as Repository;

class Project
{
    protected $repository;
    protected $factory;

    public function __construct(Repository $repository, Factory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
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
        $data = array(
            'name'        => $project->getName(),
            'description' => $project->getDescription(),
        );

        $id = $this->repository->insert($data);
        $project->setId($id);
    }

    public function update(Entity $project)
    {
        $data = array(
            'name'        => $project->getName(),
            'description' => $project->getDescription(),
            'id'          => $project->getId(),
        );

        $this->repository->update($data);
    }

    public function get($id)
    {
        $data = $this->repository->get($id);
        if (!$data) {
            throw new Exception("The project '{$id}' could not be found.");
        }

        return $this->factory->build($data);
    }

    public function getAll()
    {
        $data = $this->repository->getAll();

        $projects = array();
        foreach ($data as $row) {
            $projects[] = $this->factory->build($row);
        }

        return $projects;
    }
}