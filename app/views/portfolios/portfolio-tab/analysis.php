<?php 
  $stocks_portfolios = Spark\locals()['stocks_portfolios'];
  $portfolio = Spark\locals()['portfolio'];
  $trades = Spark\locals()['trades'];
  $sectors = Spark\locals()['sectors'];
?>


<div id='analysis-tab'>
    <div class='input-field col s12'>
    <form>
      <select id='sector-filter'>
      <?php foreach($sectors as $sector) :?>
        <option value='<?= $sector ?>'><?= $sector ?></option>
      <?php endforeach; ?>
      </select>
    </form>
    </div>

  <div id="sector-overview-chart"></div>
  <div class="row">
    <div class="col m12">
      <form method="POST" action="/trades" id="sectorStocksTradeForm">
        <input type="hidden" name="portfolioId" value="<?=$portfolio->id?>">
      </form>
      <table class='bordered' id='sector-trades-table'>
        <thead>
          <tr>
            <th >Ticker</th>
            <th>Company Name</th>
            <th>Last Price</th>
            <th>Shares Owned</th>
            <th>Trade Type</th>
            <th>Trade Quantity</th>
            <th>Sub Total</th>
          </tr>
          <tbody>
            <?php foreach($stocks_portfolios as $s_p): ?>
              <?php $ticker = $s_p->stock->ticker?>
              <tr>
                <td class="stock-ticker">
                  <input name="ticker<?=$ticker?>" type="text" form="sector
                  StocksTradeForm" value="<?=$ticker?>" readonly>
                </td>
                <td class="stock-name" data-sector='<?= $s_p->stock->sector ?>'><?= $s_p->stock->name ?></td>
                <td class='stock-sector'><?= $s_p->stock->sector ?></td>
                <td class="stock-price"><?=$s_p->stock->latest_price?></td>
                <td class="shares-number"><?= $s_p->quantity_held ?></td>
                <td class="trade-type">
                  <select name="<?=$ticker?>TradeType" form="sectorStocksTradeForm">
                    <option value="buy">BUY</option>
                    <option value="sell">SELL</option>
                  </select>
                </td>
                <td class="trade-quantity"><input name="<?=$ticker?>TradeQuantity" type='number' value="0" min="0" form="sectorStocksTradeForm"></td>
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
    <button class="btn" form="sectorStocksTradeForm">Checkout</button>
  </div>
</div>
