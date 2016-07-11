<?php use Spark\TemplateEngine AS renderer; ?>
<!doctype html>
<html>
<head>
	<title>My first PHP MVC</title>
	<?= Spark\load_javascript(); ?>
	<?= Spark\load_css(); ?>
</head>
<body>
	<?php
		renderer::render_file('layouts/header.php');
		renderer::render_view_template();
	?>
</body>
</html>