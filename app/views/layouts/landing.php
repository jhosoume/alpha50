<?php use Spark\TemplateEngine AS renderer; ?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Alpha50</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Spark\load_javascript(); ?>
    <?= Spark\load_css(); ?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <?php render_file('layouts/header.php'); ?>
    <div class="row">
      <div class="col m12">
        <div class="container">
          <?php renderer::render_view_template(); ?>
        </div>
      </div>
    </div>
    <?php render_file('layouts/footer.php'); ?>
  </body>
</html>