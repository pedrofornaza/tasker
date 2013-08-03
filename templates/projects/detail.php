<!doctype html>
<html lang="en-us">
<head>
	<meta charset="utf8" />
	<title>Tasker - Project Management made easy</title>
</head>
<body>
	<h1><?= $params['project']->getName() ?></h1>

	<p><?= $params['project']->getDescription() ?></p>

	<h2>Create a Task</h2>
	<form method="post" action="/tasks">
		<fieldset>
			<input type="hidden" name="task[project]" value="<?= $params['project']->getId() ?>" />
			<label><input placeholder="Task Name" type="text" name="task[name]" /></label>
			<label><textarea placeholder="Task Description" name="task[description]"></textarea></label>
			<label>
				<select name="task[status]">
					<option value="ready">Ready</option>
					<option value="doing">Doing</option>
					<option value="done">Done</option>
				</select>
			</label>
		</fieldset>

		<button type="submit">Save</button>
		<button type="reset">Clear</button>
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
</body>
</html>