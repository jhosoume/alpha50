<div class="row">
  <?php render_file('/portfolios/stock-side-bar.php'); ?>

  <div class="portfolio-section col s12 m10 l10">

    <div class="container new-portfolio">
      <div class='new-portfolio-overview'>
        <h5>My Awesome Portoflio</h5>
        <p> Instructions </p>
        <p><strong>Cash:</strong> 1,000,000 </p>
        <p><strong>Allocated Capital:</strong> 1,000,000 </p>
      </div>

      <div class='new-portfolio-data'>
        <table class='bordered'>
          <thead>
            <tr>
              <th data-field="stock_ticker">Ticker</th>
              <th data-field="stock_name">Company Name</th>
              <th data-field="stock_price">Price</th>
              <th data-field="shares_number">Number of Shares</th>
              <th data-field="total_value">Value ($)</th>
              <th data-field="pct_total">% of Total ($)</th>
            </tr>
            <?php $quotes = Spark\locals()['quotes'] ?>
            <tbody>
              <?php foreach($quotes as $quote): ?>
                <tr>
                  <td><?php echo $quote->ticker ?></td>
                  <td><?php echo $quote->name ?></td>
                  <td><?php echo $quote->price ?></td>
                  <td><input type='number'></td>
                  <td><?php echo $quote->price * 100 ?></td>
                  <td>% of Total</td>
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
