<?php 
$stocks_portfolios = Spark\locals()['stocks_portfolios'];
$portfolio = Spark\locals()['portfolio'];
$portfolio_equity = Spark\locals()['portfolio_equity'];
$portfolio_value = Spark\locals()['portfolio_value'];
?>

<div id="all-stocks-tab">
  <h5><?=$portfolio->name?></h5>
  <p class="cash" data-cash="<?=$portfolio->cash?>"><strong>Cash: $</strong> <?=$portfolio->cash?> </p>
  <p class="equity" data-equity="<?=$portfolio_equity?>"><strong>Equity: $</strong> <?=$portfolio_equity?> </p>
  <p class="portfolioValue" data-equity="<?=$portfolio_value?>"><strong>Portfolio Value: $</strong> <?=$portfolio_value?> </p>

  <div class="row">
    <div class="col m12">
      <table class='bordered'>
        <thead>
          <tr>
            <th>Ticker</th>
            <th>Company Name</th>
            <th>Last Price</th>
            <th>Shares Owned</th>
            <th>Trade Type</th>
            <th>Trade Quantity</th>
            <th>Sub Total</th>
          </tr>
          <tbody>
            <?php foreach($stocks_portfolios as $s_p): ?>
              <tr>
                <td class="stock-ticker"><?= $s_p->stock->ticker ?></td>
                <td class="stock-name"><?= $s_p->stock->name ?></td>
                <td class="stock-price"><?=$s_p->stock->latest_price?></td>
                <td class="shares-number"><?= $s_p->quantity_held ?></td>
                <td class="trade-type">
                  <select>
                    <option value="buy">BUY</option>
                    <option value="sell">SELL</option>
                  </select>
                </td>
                <td class="trade-quantity"><input type='number'></td>
                <td class="sub-total">$0</td>
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
      <p><strong>Net Cash</strong></p>
    </div>

    <div>
      <p class="buyingMoney">$0</p>
      <p class="sellingMoney">$0</p>
      <p class="netMoney">$0</p>
    </div>
    <hr>
    <div>
      <p><strong>Adj. Cash</strong></p>
      <p><strong>Adj. Equity</strong></p>
    </div>

    <div>
      <p class="adjustedCash">$0</p>
      <p class="adjustedEquity">$0</p>
    </div>
    <br>
    <button class="btn">Checkout</button>
  </div>
</div>