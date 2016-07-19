<?php 
  $your_portfolio = Spark\locals()['portfolio'];
  $monkey_portfolio = Spark\locals()['monkey_portfolio'];
  $index_portfolio = Spark\locals()['index_portfolio'];
  $your_stocks_portfolios = Spark\locals()['stocks_portfolios'];
  $index_stocks_portfolios = Spark\locals()['index_stocks_portfolios'];
  $monkey_stocks_portfolios = Spark\locals()['monkey_stocks_portfolios'];
  $monkey_portfolio_value = Spark\locals()['monkey_portfolio_value'];
  $index_portfolio_value = Spark\locals()['index_portfolio_value'];
  $your_portfolio_value = Spark\locals()['portfolio_value'];
  $your_inception_date = date('Y-m-d', strtotime($your_portfolio->created_at));
  $your_return = round(100*$your_portfolio->get_total_return_from($your_inception_date),2);
  $monkey_return = round(100*$monkey_portfolio->get_total_return_from($your_inception_date),2);
  $index_return = round(100*$index_portfolio->get_total_return_from($your_inception_date),2);


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
    $your_weight = round(100*($your_quantity * $latest_price) / $your_portfolio_value,2);

    $monkey_quantity;
    foreach ($monkey_stocks_portfolios as $s_p) {
      if ($s_p->stock->ticker === $ticker) {
        $monkey_quantity = $s_p->quantity_held;
      } 
    };
    $monkey_weight = round(100*($monkey_quantity * $latest_price) /$monkey_portfolio_value,2);

    $index_quantity;
    foreach ($index_stocks_portfolios as $s_p) {
      if ($s_p->stock->ticker === $ticker) {
        $index_quantity = $s_p->quantity_held;
      } 
    };
    $index_weight = round(100*($index_quantity * $latest_price) /$index_portfolio_value,2);

    $comp_info = array(
      'ticker' => $ticker, 
      'your_quantity' => $your_quantity, 
      'your_weight' => $your_weight,
      'monkey_quantity' => $monkey_quantity,
      'monkey_weight' => $monkey_weight,
      'index_weight' => $index_weight,
      );
    array_push($comparison_array, $comp_info);
   };
?>

<div id='comparison-tab'>
  <table class='return-comparison'>
    <thead>
      <tr>
        <th>Since <?= $your_inception_date?></th>
        <th>Your portfolio</th>
        <th>Your monkey</th>
        <th>Index</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class='row-header'>Total Return</td>
        <td class='user-return'><?= $your_return ?>%</td>
        <td class='monkey-return'><?= $monkey_return ?>%</td>
        <td class='index-return'><?= $index_return ?>%</td>
      </tr>
    </tbody>
  </table>

  <table class='holdings-comparison bordered'>
    <thead>
      <tr>
        <th colspan='1'></th>
        <th colspan='2'>Your portfolio</th>
        <th colspan='2'>Your monkey</th>
        <th colspan='1'>Index</th>
      </tr>
      <tr>
        <th>Ticker</th>
        <th>Quantity</th>
        <th>Weight</th>
        <th>Quantity</th>
        <th>Weight</th>
        <th>Weight</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($comparison_array as $comp_info): ?>
      <tr>  
        <td class='stock-ticker'><?= $comp_info['ticker']?></td>
        <td class='your-quantity'><?= $comp_info['your_quantity'] ?></td>
        <td class='your-weight'><?= $comp_info['your_weight'] ?>%</td>
        <td class='monkey-quantity'><?= $comp_info['monkey_quantity'] ?></td>
        <td class='monkey-weight'><?= $comp_info['monkey_weight'] ?>%</td>
        <td class='index-weight'><?= $comp_info['index_weight'] ?>%</td>
      </tr>
      <?php endforeach ; ?>
    </tbody>
  </table>
</div>