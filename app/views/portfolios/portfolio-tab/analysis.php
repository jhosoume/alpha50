<?php 
  $stocks_portfolios = Spark\locals()['stocks_portfolios'];
  $portfolio = Spark\locals()['portfolio'];
  $trades = Spark\locals()['trades'];
  $sectors = Spark\locals()['sectors'];
?>


<div id='analysis-tab'>
    <div class='input-field col s12'>
    <form>
      <select id='sector-filter' class='teal-text darken-4'>
      <?php foreach($sectors as $sector) :?>
        <option value='<?= $sector ?>'><?= $sector ?></option>
      <?php endforeach; ?>
      </select>
    </form>
    </div>

  <div id="sector-overview-chart"></div>
  <div class="row">
    <div class="col m12">
      <table class='bordered highlight' id='sector-trades-table'>
        <thead class='teal-text darken-4'>
          <tr>
            <th>Ticker</th>
            <th>Company Name</th>
            <th>Last<br>Price</th>
            <th>Shares<br>Owned</th>
            <th>Value</th>
          </tr>
        </thead>
          <tbody>
            <?php foreach($stocks_portfolios as $s_p): ?>
              <?php $ticker = $s_p->stock->ticker?>
              <?php $value = number_format(floor($s_p->quantity_held * $s_p->stock->latest_price)) ?>
              <tr>
                <td class="stock-ticker">
                  <input name="ticker<?=$ticker?>" type="text" form="sector
                  StocksTradeForm" value="<?=$ticker?>" readonly>
                </td>
                <td class="stock-name" data-sector='<?= $s_p->stock->sector ?>'><?= $s_p->stock->name ?></td>
                <td class="stock-price"><?=$s_p->stock->latest_price?></td>
                <td class="shares-number"><?= $s_p->quantity_held ?></td>
                <td clss='stock-value'><?= $value ?></td>
              </tr>
            <?php endforeach ; ?>   
          </tbody>
      </table>
    </div>
  </div>

</div>
