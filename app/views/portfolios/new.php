<div class="portfolio-section col s12 m10 l10">
  <?php render_file('/portfolios/portfolio-tab/portfolio_nav.php') ?>
  <form method="POST" action="/portfolios" id="newPortfolioForm"></form>
  <div class='new-portfolio-overview'>
    <h5 id='portfolio-name'><input class="validate" type="text" value="My Awesome Portoflio" name="name" form="newPortfolioForm" pattern=".{2,}" required title="2 characters minimum"></h5>
    <p> Instructions </p>
    <p><strong>Cash: </strong><span class='cash-holdings'></span></p>
    <p><strong>Allocated Capital: </strong><span class='equity-holdings'></span></p>
  </div>

  <div class='new-portfolio-data'>
    <table class='bordered'>
      <thead>
        <tr>
          <th data-field="stock-ticker">Ticker</th>
          <th data-field="stock-name">Company Name</th>
          <th data-field="stock-price">Price</th>
          <th data-field="number-of-shares">Number of Shares</th>
          <th data-field="total-value">Value ($)</th>
          <th data-field="pct-of-total">% of Total ($)</th>
        </tr>
        <?php $index = Spark\locals()['index_portfolio'] ?>
        <?php $index_value = Spark\locals()['index_value'] ?>
        <?php $startingCapital = 1000000 ?>
        <tbody>
          <?php foreach($index->stocks_portfolios as $sp): ?>
          <?php $stock = $sp->stock?>
          <?php $pct_weight = $stock->latest_price*$sp->quantity_held / $index_value ?>
          <?php $number_of_shares = floor($startingCapital * $pct_weight / $stock->latest_price) ?>
            <tr> 
              <td class='stock-ticker'>
                <input type="text" name="ticker<?= $stock->ticker?>" value="<?= $stock->ticker?>" form="newPortfolioForm" readonly>
              </td>
              <td class='stock-name'><?php echo $stock->name ?></td>
              <td class='stock-price'><?= $stock->latest_price ?></td>
              <td class='number-of-shares'><input type='number' name="<?=$stock->ticker?>TradeQuantity" value='<?= $number_of_shares ?>' form="newPortfolioForm" min="0">
              </td>
              <td class='total-value'>
                <input form='newPortfolioForm' type='number' value='' readonly>
              </td>
              <td><?= $pct_weight ?></td>
            </tr>
          <?php endforeach ; ?>    
        </tbody>
      </thead>
    </table>
    <button class='btn create-portfolio-btn' form="newPortfolioForm">Create Portfolio</button>
  </div>
</div>

<?php 
render_file('/layouts/preloader.php');
load_template('/stock_sidebar.hbs');
