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

		<a href="#" class="button show-project-form">Create a Project</a>
		<form method="post" action="/projects" class="project-form">
			<fieldset>
				<div class="line buttons">
					<a href="#" class="hide-project-form"><img src="/img/close.png" /></a>
				</div>

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

		<?php if (!empty($params['projects'])) : ?>
		<ul>
			<?php foreach ($params['projects'] as $project) : ?>
				<?php $projectid = $project->getId(); ?>
				<li><a href="/projects/<?= $projectid ?>">#<?= $projectid ?></a> - <?= $project->getName() ?></li>
			<?php endforeach ?>
		</ul>
		<?php endif ?>
	</div>

	<script type="text/javascript" src="/js/app.js"></script>
	<script type="text/javascript">
		makeHiddenForm('project');
	</script>
</body>
</html>