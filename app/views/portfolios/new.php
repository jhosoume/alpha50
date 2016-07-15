<div class="row">
  <?php render_file('/portfolios/stock-side-bar.php'); ?>

  <div class="portfolio-section col s12 m10 l10">

    <div class="container new-portfolio">
      <div class='new-portfolio-overview'>
        <h5>My Awesome Portoflio</h5>
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
            <?php $quotes = Spark\locals()['quotes'] ?>
            <tbody>
              <?php foreach($quotes as $quote): ?>
                <tr>
                  <td class='stock-ticker'><?php echo $quote->ticker ?></td>
                  <td class='stock-name'><?php echo $quote->name ?></td>
                  <td class='stock-price'><?php echo $quote->price ?></td>
                  <td class='number-of-shares'><input type='number' value='40'></td>
                  <td class='total-value'><?php echo $quote->price * 100 ?></td>
                  <td class='pct-of-total'></td>
                </tr>
              <?php endforeach ; ?>    
            </tbody>
          </thead>
        </table>
        <button class='btn'>Create Portfolio</button>
      </div>
      </div>
  </div>
</div>

</div>

<?php 

render_file('/layouts/preloader.php');
load_template('/stock_sidebar.hbs');
