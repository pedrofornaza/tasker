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
	<form method="post" action="/times" id="end-form">
		<input type="hidden" name="time[type]" value="end" />
		<input type="hidden" name="time[task]" value="<?= $params['task']->getId() ?>"/>
		<ul>
			<?php foreach ($params['times'] as $time) : ?>
				<li>
					<?= $time->getStart() ?> - 
					<?php if ($time->getEnd() == null) : ?> 
						<button type="button" class="form-submit" value="<?= $time->getId() ?>">Close</button>
					<?php else: ?>
						<?= $time->getEnd() ?>
					<?php endif ?>
				</li>
			<?php endforeach ?>
		</ul>
	</form>
	<?php endif ?>

	<script type="text/javascript">
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