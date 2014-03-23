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
				<li><a href="/projects/<?= $params['task']->getProject() ?>"><img src="/img/back-arrow.png" /> Back to Project</a></li>
			</ul>
		</div>

		<h1>#<?= $params['task']->getId() ?> - <?= $params['task']->getName() ?></h1>

		<p>Description: <?= $params['task']->getDescription() ?></p>
		<p>Status: <?= ucfirst($params['task']->getStatus()) ?></p>

		<a href="#" class="button show-task-form">Edit Task</a>

		<form method="post" action="/times" class="time-form">
			<input type="hidden" name="time[type]" value="start" />
			<input type="hidden" name="time[task]" value="<?= $params['task']->getId() ?>" />
			<button type="submit" class="button">Start Time</button>
		</form>

		<form method="post" action="/tasks/<?= $params['task']->getId() ?>" class="task-form">
			<fieldset>
				<input type="hidden" name="task[project]" value="<?= $params['task']->getProject() ?>" />

				<div class="line buttons">
					<a href="#" class="hide-task-form"><img src="/img/close.png" /></a>
				</div>

				<div class="line">
					<label for="task-name">Task Name: </label>
					<input placeholder="Task Name" type="text" id="task-name" name="task[name]" value="<?= $params['task']->getName() ?>" />
				</div>

				<div class="line">
					<label for="task-desc">Task Description: </label>
					<textarea placeholder="Task Description" name="task[description]" id="task-desc" rows="5"><?= $params['task']->getDescription() ?></textarea>
				</div>

				<div class="line">
					<label for="task-status">Task Status: </label>
					<select name="task[status]" id="task-status">
						<option value="ready" <?= ($params['task']->getStatus() == 'ready') ? 'selected="selected"' : '' ?>>Ready</option>
						<option value="doing" <?= ($params['task']->getStatus() == 'doing') ? 'selected="selected"' : '' ?>>Doing</option>
						<option value="done" <?= ($params['task']->getStatus() == 'done') ? 'selected="selected"' : '' ?>>Done</option>
					</select>
				</div>

				<div class="line buttons">
					<button type="submit" class="button">Save</button>
					<button type="reset" class="button">Clear</button>
				</div>
			</fieldset>
		</form>

		<?php if (!empty($params['times'])) : ?>
		<h2>Times</h2>
		<form method="post" action="/times" id="end-form">
			<input type="hidden" name="time[type]" value="end" />
			<input type="hidden" name="time[task]" value="<?= $params['task']->getId() ?>"/>
			<ul>
				<?php foreach ($params['times'] as $time) : ?>
					<li>
						Start: <?= $time->getStart() ?> - 
						<?php if ($time->getEnd() == null) : ?> 
							<button type="button" class="form-submit button" value="<?= $time->getId() ?>">Close</button>
						<?php else: ?>
							End: <?= $time->getEnd() ?>
						<?php endif ?>
					</li>
				<?php endforeach ?>
			</ul>
		</form>
		<?php endif ?>
	</divv>

	<script type="text/javascript" src="/js/app.js"></script>
	<script type="text/javascript">
		makeHiddenForm('task');

		var buttons = document.querySelectorAll('.form-submit');

		for(var i = 0; i < buttons.length; i++) {
			buttons[i].onclick = function() {
				var endForm = document.querySelector('#end-form');
				endForm.action += '/' + this.value;

				endForm.submit();
			}
		}
	</script>
</body>
</html>