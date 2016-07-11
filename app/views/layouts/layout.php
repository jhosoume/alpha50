<?php use Spark\TemplateEngine AS renderer; ?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Alpha50</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Spark\load_javascript(); ?>
    <?= Spark\load_css(); ?>
  </head>
  <body>
    <?php renderer::render_file('layouts/header.php'); ?>
    <main>
    <?php renderer::render_view_template(); ?>
    </main>
    <?php renderer::render_file('layouts/footer.php'); ?>
  </body>
</html>