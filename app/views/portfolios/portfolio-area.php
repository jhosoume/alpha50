<div class="portfolio-area col s12 m10 l10">
  <div class="container">
    <?php render_file('/portfolios/portfolio-tab/portfolio_nav.php') ?>
    <div class='portfolio-content'>
      <?php render_file('/portfolios/portfolio-tab/overview.php') ?>
      <?php render_file('/portfolios/portfolio-tab/all_stocks.php') ?>
      <?php render_file('/portfolios/portfolio-tab/analysis.php') ?>
      <?php render_file ('portfolios/portfolio-tab/comparison.php') ?>
      <?php render_file('/portfolios/portfolio-tab/trades.php') ?>   
    </div>
  </div>
</div>

<?php render_file('/layouts/preloader.php') ?>