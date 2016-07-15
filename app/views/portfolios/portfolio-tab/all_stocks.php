<?php $stocks_portfolios = Spark\locals()['stocks_portfolios'] ?>
<?php $portfolio = Spark\locals()['portfolio'] ?>

<div id="all-stocks-tab">
  <div class="container new-portfolio">
      <div class='new-portfolio-overview'>
        <h5><?=$portfolio->name?></h5>
        <p><strong>Cash: $</strong> <?=$portfolio->cash?> </p>
      </div>
      <div class='new-portfolio-data'>
        <div class="row">
          <div class="col m12">
            <table class='bordered'>
              <thead>
                <tr>
                  <th data-field="stock_ticker">Ticker</th>
                  <th data-field="stock_name">Company Name</th>
                  <th data-field="stock_price">Last Price</th>
                  <th data-field="shares_number">Shares Owned</th>
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
        <div class="all-stocks-checkout">
          <div>
            <p><strong>Buying</strong></p>
            <p><strong>Selling</strong></p>
          </div>

          <div>
            <p>$100</p>
            <p>$200</p>
          </div>
          <hr>
          <div>
            <p><strong>Adj. Cash</strong></p>
            <p><strong>Adj. Equity</strong></p>
          </div>

          <div>
            <p>$1100</p>
            <p>$22000</p>
          </div>
          <br>
          <button class="btn">Checkout</button>
        </div>
      </div>
    </div>
  </div>