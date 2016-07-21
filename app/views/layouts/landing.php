<?php use Spark\TemplateEngine AS renderer; ?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Alpha50</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
    <?= Spark\load_assets(); ?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <?php render_file('layouts/header.php'); ?>
    <?php renderer::render_view_template(); ?>
    <?php render_file('layouts/footer.php'); ?>
  </body>
</html>