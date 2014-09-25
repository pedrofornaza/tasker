<?php

namespace Tasker\Domain\Project;

use Exception;

class ProjectMapper
{
    protected $repository;
    protected $factory;

    public function __construct(ProjectRepository $repository, ProjectFactory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function save(ProjectEntity $project)
    {
        if ($project->getId() !== null) {
            $this->update($project);

        } else {
            $this->insert($project);
        }
    }

    protected function insert(ProjectEntity $project)
    {
        $data = array(
            'name'        => $project->getName(),
            'description' => $project->getDescription(),
        );

        $id = $this->repository->insert($data);
        $project->setId($id);
    }

    protected function update(ProjectEntity $project)
    {
        $data = array(
            'id'          => $project->getId(),
            'name'        => $project->getName(),
            'description' => $project->getDescription(),
        );

        $this->repository->update($data);
    }

    public function find($id)
    {
        $data = $this->repository->find($id);
        if (!$data) {
            throw new Exception("The project '{$id}' could not be found.");
        }

        return $this->factory->newEntity($data);
    }

    public function findAll()
    {
        $data = $this->repository->findAll();
        return $this->factory->newCollection($data);
    }
}