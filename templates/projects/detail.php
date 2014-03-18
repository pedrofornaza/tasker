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

		<h2>Create a Task</h2>
		<form method="post" action="/tasks">
			<fieldset>
				<input type="hidden" name="task[project]" value="<?= $params['project']->getId() ?>" />

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
</body>
</html>