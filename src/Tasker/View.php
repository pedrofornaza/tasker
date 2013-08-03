<?php

namespace Tasker;

class View
{
	public function __construct($path = '')
	{
		$path = realpath($path);
		if (!file_exists($path)) {
			throw new \InvalidArgumentException("The View '{$path}' does not exists.");
		}

		$this->path = $path;
	}

	public function render($params = array())
	{
		ob_start();
		include $this->path;
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}