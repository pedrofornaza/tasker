<!doctype html>
<html lang="en-us">
<head>
	<meta charset="utf8" />
	<title>Tasker - Project Management made easy</title>
</head>
<body>
	<h1>Projects</h1>

	<?php if (!empty($params['projects'])) : ?>
	<ul>
		<?php foreach ($params['projects'] as $project) : ?>
			<li><?= $project->getName() ?> - <a href="/projects/<?= $project->getId() ?>">View</a></li>
		<?php endforeach ?>
	</ul>
	<?php endif ?>

	<h2>Create a Project</h2>
	<form method="post" action="/projects">
		<fieldset>
			<label><input placeholder="Project Name" type="text" name="project[name]" /></label>
			<label><textarea placeholder="Project Description" name="project[description]"></textarea></label>
		</fieldset>

		<button type="submit">Save</button>
		<button type="reset">Clear</button>
	</form>
</body>
</html>