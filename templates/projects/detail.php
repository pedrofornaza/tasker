<!doctype html>
<html lang="en-us">
<head>
	<meta charset="utf8" />
	<title>Tasker - Project Management made easy</title>

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="/css/general.css" />
</head>
<body>
	<div id="content">
		<div id="header">
			<ul id="menu">
				<li><a href="/projects"><img src="/img/back-arrow.png" /> Back to Projects</a></li>
			</ul>
		</div>

		<h1>#<?= $params['project']->getId() ?> - <?= $params['project']->getName() ?></h1>

		<p><?= $params['project']->getDescription() ?></p>

		<a href="#" class="button show-project-form">Edit Project</a>
		<a href="#" class="button show-task-form">Create a Task</a>

		<form method="post" action="/projects/<?= $params['project']->getId() ?>" class="project-form">
			<fieldset>
				<div class="line buttons">
					<a href="#" class="hide-project-form"><img src="/img/close.png" /></a>
				</div>

				<div class="line">
					<label for="project-name">Project Name: </label>
					<input placeholder="Project Name" type="text" name="project[name]" id="project-name" value="<?= $params['project']->getName() ?>" />
				</div>

				<div class="line">
					<label for="project-desc">Project Description: </label>
					<textarea placeholder="Project Description" name="project[description]" id="project-desc" rows="5"><?= $params['project']->getDescription() ?></textarea>
				</div>

				<div class="line buttons">
					<button type="submit" class="button">Save</button>
					<button type="reset" class="button">Clear</button>
				</div>
			</fieldset>
		</form>

		<form method="post" action="/tasks" class="task-form">
			<fieldset>
				<input type="hidden" name="task[project]" value="<?= $params['project']->getId() ?>" />

				<div class="line buttons">
					<a href="#" class="hide-task-form"><img src="/img/close.png" /></a>
				</div>

				<div class="line">
					<label for="task-name">Task Name: </label>
					<input placeholder="Task Name" type="text" id="task-name" name="task[name]" />
				</div>

				<div class="line">
					<label for="task-desc">Task Description: </label>
					<textarea placeholder="Task Description" name="task[description]" id="task-desc" rows="5"></textarea>
				</div>

				<div class="line">
					<label for="task-status">Task Status: </label>
					<select name="task[status]" id="task-status">
						<option value="ready">Ready</option>
						<option value="doing">Doing</option>
						<option value="done">Done</option>
					</select>
				</div>

				<div class="line buttons">
					<button type="submit" class="button">Save</button>
					<button type="reset" class="button">Clear</button>
				</div>
			</fieldset>
		</form>

		<?php if (!empty($params['tasks'])) : ?>
		<h2>Tasks</h2>
		<ul>
			<?php foreach ($params['tasks'] as $task) : ?>
				<?php $taskid = $task->getId(); ?>
				<li><a href="/tasks/<?= $taskid ?>">#<?= $taskid ?></a> - <?= $task->getName() ?></li>
			<?php endforeach ?>
		</ul>
		<?php endif ?>
	</div>

	<script type="text/javascript" src="/js/app.js"></script>
	<script type="text/javascript">
		makeHiddenForm('project');
		makeHiddenForm('task');
	</script>
</body>
</html>