<!doctype html>
<html lang="en-us">
<head>
	<meta charset="utf8" />
	<title>Tasker - Project Management made easy</title>
</head>
<body>
	<h1>#<?= $params['task']->getId() ?> - <?= $params['task']->getName() ?></h1>

	<p>Description: <?= $params['task']->getDescription() ?></p>
	<p>Status: <?= ucfirst($params['task']->getStatus()) ?></p>

	<form method="post" action="/times">
		<input type="hidden" name="time[type]" value="start" />
		<input type="hidden" name="time[task]" value="<?= $params['task']->getId() ?>" />
		<button type="submit">Start Time</button>
	</form>

	<?php if (!empty($params['times'])) : ?>
	<h2>Times</h2>
	<ul>
		<?php foreach ($params['times'] as $time) : ?>
			<li><?= $time->getStart() ?> <?php if ($time->getEnd() == null) : ?> - <a href="/time/<?= $time->getId() ?>">Close</a><?php endif; ?></li>
		<?php endforeach ?>
	</ul>
	<?php endif ?>
</body>
</html>