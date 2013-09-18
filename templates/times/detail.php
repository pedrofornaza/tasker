<!doctype html>
<html lang="en-us">
<head>
	<meta charset="utf8" />
	<title>Tasker - Project Management made easy</title>
</head>
<body>
	<h1>#<?= $params['time']->getId() ?></h1>

	<p>Start: <?= $params['time']->getStart() ?></p>

	<form method="post" action="/times/<?= $params['time']->getId() ?>">
		<input type="hidden" name="time[type]" value="end" />
		<input type="hidden" name="time[task]" value="<?= $params['time']->getTask() ?>" />
		<button type="submit">End Time</button>
	</form>
</body>
</html>