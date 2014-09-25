<?php

namespace Tasker\Domain\Project;

interface ProjectRepository
{
    public function save(ProjectEntity $project);
    public function find($id);
    public function findAll();
}