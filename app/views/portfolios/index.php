<div class="row">
  <?php render_file('/portfolios/stock-side-bar.php'); ?>

  <div class="portfolio-section col s12 m10 l10">

      <div class="container">
        <div class="row">
          <div class='col s11 intra-portfolio-area'>
            <?php render_file('/portfolios/portfolio-tab/portfolio_nav.php') ?>
            <div class='portfolio-content'>
             <?php render_file('/portfolios/portfolio-tab/overview.php') ?>
             <?php render_file('/portfolios/portfolio-tab/all_stocks.php') ?>
             <?php render_file('/portfolios/portfolio-tab/analysis.php') ?>
              <?php render_file ('portfolios/portfolio-tab/comparison.php') ?>
              <?php render_file('/portfolios/portfolio-tab/trades.php') ?>   
            </div>
            <div class="portfolio-footer"></div>
          </div>
        </div>
      </div>
  </div>

</div>

<?php 

render_file('/layouts/preloader.php');
load_template('/stock_sidebar.hbs');
