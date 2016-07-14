<div class="portfolio-section col s12 m10 l10">

    <div class="container">
      <div class="row">
<!--         <nav>
          <ul class="right hide-on-med-and-down">
            <li><a href="#!">First Sidebar Link</a></li>
            <li><a href="#!">Second Sidebar Link</a></li>
          </ul>
          <ul id="slide-out" class="side-nav">
            <li><a href="#!">First Sidebar Link</a></li>
            <li><a href="#!">Second Sidebar Link</a></li>
          </ul>
          <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu">reo</i></a>
        </nav> -->


        <div class='col s11 intra-portfolio-area'>
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
    </div>
</div>

<?php render_file('/layouts/preloader.php') ?>