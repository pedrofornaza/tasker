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
				<li><a href="/projects">Projects</a></li>
			</ul>
		</div>

		<h1>Projects</h1>

		<?php if (!empty($params['projects'])) : ?>
		<ul>
			<?php foreach ($params['projects'] as $project) : ?>
				<?php $projectid = $project->getId(); ?>
				<li><a href="/projects/<?= $projectid ?>">#<?= $projectid ?></a> - <?= $project->getName() ?></li>
			<?php endforeach ?>
		</ul>
		<?php endif ?>

		<h2>Create a Project</h2>
		<form method="post" action="/projects">
			<fieldset>
				<div class="line">
					<label for="project-name">Project Name: </label>
					<input placeholder="Project Name" type="text" name="project[name]" id="project-name" />
				</div>

				<div class="line">
					<label for="project-desc">Project Description: </label>
					<textarea placeholder="Project Description" name="project[description]" id="project-desc" rows="5"></textarea>
				</div>

				<div class="line buttons">
					<button type="submit" class="button">Save</button>
					<button type="reset" class="button">Clear</button>
				</div>
			</fieldset>
		</form>
	</div>
</body>
</html>