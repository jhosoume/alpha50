<div id="overview-tab" style='color:red'>
  <?php 
    $portfolio = Spark\locals()['portfolio']; 
    $portfolio_equity = Spark\locals()['portfolio_equity'] 
  ?>
  <div id='portfolio-holdings-chart' data-portfolio-cash="<?= $portfolio->total_cash ?>" data-portfolio-equity="<?= $portfolio_equity ?> "></div>
  <div id="portfolio-overview-chart"></div>
</div>