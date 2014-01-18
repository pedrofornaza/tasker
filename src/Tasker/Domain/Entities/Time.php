<?php

namespace Tasker\Domain\Entities;

use DateTime;
use InvalidArgumentException;

class Time
{
	protected $id;
	protected $task;
	protected $start;
	protected $end;

	public function setId($id)
	{
		if (!is_int($id) &&
			!is_numeric($id)
		) {
			throw new InvalidArgumentException('The time id must be integer.');
		}

		$this->id = (int) $id;
		return $this;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setTask($task)
	{
		if (!is_int($task) && 
			!is_numeric($task)
		) {
			throw new InvalidArgumentException('The time task must be integer.');
		}

		$this->task = (int) $task;
		return $this;
	}

	public function getTask()
	{
		return $this->task;
	}

	public function setStart($time)
	{
		$datetime = new DateTime($time);
		$errors = $datetime->getLastErrors();
		if ($errors['error_count'] > 0) {
			throw new InvalidArgumentException('The task start must be a valid datetime and on format m/d/Y h:i:s.');
		}

		$this->start = $datetime;
		return $this;
	}

	public function getStart()
	{
		$start = null;
		if ($this->start instanceof DateTime) {
			$start = $this->start->format('Y-m-d h:i:s');
		}

		return $start;
	}

	public function setEnd($time)
	{
		if ($time == null) {
			return $this;
		}

		$datetime = new DateTime($time);
		$errors = $datetime->getLastErrors();
		if ($errors['error_count'] > 0) {
			throw new InvalidArgumentException('The task end must be a valid datetime and on format m/d/Y h:i:s.');
		}

		$this->end = $datetime;
		return $this;
	}

	public function getEnd()
	{
		$end = null;
		if ($this->end instanceof DateTime) {
			$end = $this->end->format('Y-m-d h:i:s');
		}

		return $end;
	}
}