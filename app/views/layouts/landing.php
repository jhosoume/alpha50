<?php use Spark\TemplateEngine AS renderer; ?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Alpha50</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script
        src="https://code.jquery.com/jquery-3.1.0.min.js"
        integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
        crossorigin="anonymous"></script>
    <?= Spark\load_javascript(); ?>
    <?= Spark\load_css(); ?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <?php render_file('layouts/header.php'); ?>
    <?php renderer::render_view_template(); ?>
    <?php render_file('layouts/footer.php'); ?>
  </body>
</html>