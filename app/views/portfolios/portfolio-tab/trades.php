<?php 
  $stocks_portfolios = Spark\locals()['stocks_portfolios'];
  $portfolio = Spark\locals()['portfolio'];
  $trades = Spark\locals()['trades'];
?>

<div id="trades-tab">
  <table>
    <thead>
      <tr>
        <th>Date</th>
        <th>Ticker</th>
        <th>Company Name</th>
        <th>Trade Type</th>
        <th>Trade Quantity</th>
        <th>Trade Total</th>
      </tr>
    </thead>
    <tbody>
    <?php 
      foreach($trades as $trade):
      $stock = $trade->stocks_portfolio->stock;
      $trade_total = abs(round($trade->quantity*$trade->price, 2));
      $trade_type = $trade->quantity > 0 ? "BUY" : "SELL";
    ?>
    <tr>
      <td><?= format_date($trade->created_at) ?></td>
      <td><?= $stock->ticker ?></td>
      <td><?= $stock->name ?></td>
      <td><?= $trade_type ?></td>
      <td><?= number_format(abs($trade->quantity)) ?></td>
      <td>$<?= number_format($trade_total) ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>