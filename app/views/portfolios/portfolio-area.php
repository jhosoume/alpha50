<div class="portfolio-area col s12 m10 l10">
  <div class="container">
    <?php Spark\TemplateEngine::render_file('/portfolios/portfolio-tab/portfolio_nav.php') ?>
    <div class='portfolio-content'>
      <?php Spark\TemplateEngine::render_file('/portfolios/portfolio-tab/overview.php') ?>
      <?php Spark\TemplateEngine::render_file('/portfolios/portfolio-tab/all_stocks.php') ?>
      <?php Spark\TemplateEngine::render_file('/portfolios/portfolio-tab/analysis.php') ?>
      <?php Spark\TemplateEngine::render_file ('portfolios/portfolio-tab/comparison.php') ?>
      <?php Spark\TemplateEngine::render_file('/portfolios/portfolio-tab/trades.php') ?>   
    </div>
  </div>
</div>

<?php Spark\TemplateEngine::render_file('/layouts/preloader.php') ?>