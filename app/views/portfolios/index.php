<div class="row">
  <?php render_file('/portfolios/stock-side-bar.php'); ?>

  <?php render_file('/portfolios/portfolio-area.php'); ?>
</div>

<?php render_file('/layouts/preloader.php') ?>

<script id="stock-quote-hbs" type='text/x-handlebar-template' >
  <div class="stock-quote">
    <p>
      {{stock.name}} - ({{stock.tic}})
    </p><p>
      {{stock.price}}
    </p>
  </div>
</script>