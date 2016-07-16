<div class="row">
  <?php render_file('/portfolios/stock-side-bar.php'); ?>

  <div class="portfolio-section col s12 m10 l10">

    <div class="container new-portfolio">
      <div class='new-portfolio-overview'>
        <h5 id='portfolio-name' contenteditable="true">My Awesome Portoflio</h5>
        <p> Instructions </p>
        <p><strong>Cash: </strong><span class='cash-holdings'></span></p>
        <p><strong>Allocated Capital: </strong><span class='equity-holdings'></span></p>
      </div>

      <div class='new-portfolio-data'>
        <form id='portfolio-data-form' method='POST' action='/portfolios'>
          <input type='hidden' name='data' value=''>
        </form>

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
                  <td class='stock-ticker'><?= $stock->ticker ?></td>
                  <td class='stock-name'><?php echo $stock->name ?></td>
                  <td class='stock-price'><?= $stock->latest_price ?></td>
                  <td class='number-of-shares'><input type='number' value='<?= $number_of_shares ?>'>
                  </td>
                  <td class='total-value'>
                    <input form='create-portfolio' type='number' value='' readonly>
                  </td>
                  <td class='pct-of-total'><?= $pct_weight ?></td>
                </tr>
              <?php endforeach ; ?>    
            </tbody>
          </thead>
        </table>
        <button class='btn create-portfolio-btn'>Create Portfolio</button>
      </div>
      </div>
  </div>
</div>

</div>

<?php 

render_file('/layouts/preloader.php');
load_template('/stock_sidebar.hbs');
