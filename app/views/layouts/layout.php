<?php use Spark\TemplateEngine AS renderer; ?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Alpha50</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Spark\load_assets(); ?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <?php render_file('layouts/header.php'); ?>
    <div class="row main-row" style='margin-bottom: 0'>
      <div class="col m2 side-area">
        <?php render_file('/portfolios/stock-side-bar.php'); ?>
      </div>
      <div class="col s12 m10">
        <div class="container">
          <?php renderer::render_view_template(); ?>
        </div>
      </div>
    </div>
    <?php render_file('layouts/footer.php'); ?>
  </body>
</html>