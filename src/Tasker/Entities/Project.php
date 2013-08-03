<?php

namespace Tasker\Entities;

class Project
{
	protected $id;
	protected $name;
	protected $description;

	public function setId($id)
	{
		if (!is_int($id) &&
			!is_numeric($id)
		) {
			throw new \InvalidArgumentException('The project id must be integer.');
		}

		$this->id = (int) $id;
		return $this;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setName($name)
	{
		$name = trim($name);
		if ($name == '') {
			throw new \InvalidArgumentException('The project name cannot be null.');
		}

		$this->name = $name;
		return $this;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setDescription($description)
	{
		$description = trim($description);
		$this->description = $description;
		return $this;
	}

	public function getDescription()
	{
		return $this->description;
	}
}