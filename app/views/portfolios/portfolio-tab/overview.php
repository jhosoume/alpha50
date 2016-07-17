<div id="overview-tab" style='color:red'>
  <?php 
    $portfolio = Spark\locals()['portfolio']; 
    $portfolio_equity_value = Spark\locals()['portfolio_equity_value'] 
  ?>
  <div id='portfolio-holdings-chart' data-portfolio-cash="<?= $portfolio->total_cash ?>" data-portfolio-equity="<?= $portfolio_equity_value ?> "></div>
  <div id="portfolio-overview-chart"></div>
</div>