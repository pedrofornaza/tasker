<?php

namespace Tasker\Infra\Persistence\Project;

use Exception;
use Tasker\Domain\Project\ProjectEntity;
use Tasker\Domain\Project\ProjectFactory;
use Tasker\Domain\Project\ProjectRepository;

class ProjectMapper implements ProjectRepository
{
    protected $gateway;
    protected $factory;

    public function __construct(ProjectGateway $gateway, ProjectFactory $factory)
    {
        $this->gateway = $gateway;
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

        $id = $this->gateway->insert($data);
        $project->setId($id);
    }

    protected function update(ProjectEntity $project)
    {
        $data = array(
            'id'          => $project->getId(),
            'name'        => $project->getName(),
            'description' => $project->getDescription(),
        );

        $this->gateway->update($data);
    }

    public function find($id)
    {
        $data = $this->gateway->find($id);
        if (!$data) {
            throw new Exception("The project '{$id}' could not be found.");
        }

        return $this->factory->newEntity($data);
    }

    public function findAll()
    {
        $data = $this->gateway->findAll();
        return $this->factory->newCollection($data);
    }
}