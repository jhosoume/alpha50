<?php 
  $your_stocks_portfolios = Spark\locals()['stocks_portfolios'];
  $index_stocks_portfolios = Spark\locals()['index_stocks_portfolios'];
  $monkey_stocks_portfolios = Spark\locals()['monkey_stocks_portfolios'];

  $comparison_array=array();
  for ($i=0;$i < 50;$i++) {
    $ticker = $index_stocks_portfolios[$i]->stock->ticker;
    $latest_price = $index_stocks_portfolios[$i]->stock->latest_price;
    $your_quantity;
    foreach ($your_stocks_portfolios as $s_p) {
      if ($s_p->stock->ticker == $ticker) {
        $your_quantity = $s_p->quantity_held;
      }
    };
    $monkey_quantity;
    foreach ($monkey_stocks_portfolios as $s_p) {
      if ($s_p->stock->ticker === $ticker) {
        $monkey_quantity = $s_p->quantity_held;
      } 
    };
    $stock = array('ticker' => $ticker, 'your_quantity' => $your_quantity, 'monkey_quantity' => $monkey_quantity);
    array_push($comparison_array, $stock);
   };
?>

<strong><?= $your_stocks_portfolios[0]->stock->ticker ?></strong>
<div id='comparison-tab'>
  <table class='return-comparison'>
    <thead>
      <tr>
        <th></th>
        <th>Your portfolio</th>
        <th>Your monkey</th>
        <th>Index</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class='row-header'>Total Return</td>
        <td class='user-return'>100</td>
        <td class='monkey-return'>100</td>
        <td class='index-return'>100</td>
      </tr>
    </tbody>
  </table>

  <table class='holdings-comparison bordered'>
    <thead>
      <tr>
        <th></th>
        <th colspan='2'>Your portfolio</th>
        <th colspan='2'>Your monkey</th>
        <th colspan='1'>Index</th>
      </tr>
      <tr>
        <th>Ticker</th>
        <th>Quantity</th>
        <th>Weight</th>
        <th>Quanity</th>
        <th>Weight</th>
        <th>Weight</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($your_stocks_portfolios as $s_p): ?>
      <tr>  
        <td class='stock-ticker'><?= $s_p->stock->ticker ?></td>
        <td class='your-quantity'><?= $s_p->quantity_held ?></td>
        <td>Boom</td>
        <td>Bomm</td>
        <td>Boom</td>
        <td>Boom</td>
      </tr>
      <?php endforeach ; ?>
    </tbody>
  </table>
</div>