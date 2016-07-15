<?php $stocks_portfolios = Spark\locals()['stocks_portfolios'] ?>
<?php $portfolio = Spark\locals()['portfolio'] ?>
<div id="all-stocks-tab">
  <div class="container new-portfolio">
      <div class='new-portfolio-overview'>
        <h5><?=$portfolio->name?></h5>
        <p> Instructions </p>
        <p><strong>Cash: $</strong> <?=$portfolio->cash?> </p>
      </div>

      <div class='new-portfolio-data'>
        <table class='bordered'>
          <thead>
            <tr>
              <th data-field="stock_ticker">Ticker</th>
              <th data-field="stock_name">Company Name</th>
              <th data-field="stock_price">Last Price</th>
              <th data-field="shares_number">Shares Owned</th>
              <th data-field="total_value">Value ($)</th>
              <th data-field="trade_type">Trade Type</th>
              <th data-field="trade_quantity">Trade Quantity</th>
              <th data-field="transaction_total">Transaction Total</th>
            </tr>
            <tbody>
              <?php foreach($stocks_portfolios as $s_p): ?>
                <tr>
                  <td><?= $s_p->stock->ticker ?></td>
                  <td><?= $s_p->stock->name ?></td>
                  <td>$0</td>
                  <td><?= $s_p->quantity_held ?></td>
                  <td> 232 </td>
                  <td>
                    <select>
                      <option value="buy">BUY</option>
                      <option value="sell">SELL</option>
                    </select>
                  </td>
                  <td><input type='number'></td>
                  <td>0</td>
                </tr>
              <?php endforeach ; ?>    
            </tbody>
          </thead>
        </table>
      </div>
      </div>
</div>