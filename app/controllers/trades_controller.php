<?php
class TradesController extends Spark\BaseController {
  public function create() {
    $params = $this->params;
    $keys = array_keys($params);
    $portfolio = Portfolio::find($params['portfolioId']);
    $stocks_portfolios = StocksPortfolio::find('all', array('conditions'=>['portfolio_id = ?', $portfolio->id], 'include' => array('stock')));

    for($i = 0; $i < count($keys); $i++) {
      $key = $keys[$i];
      if (strpos($key, 'ticker') === 0) {
        $ticker = $params[$key];
        $trade_type = $params[$ticker.'TradeType'];
        $quantity = intval($params[$ticker.'TradeQuantity']);

        // Make sure user submitted quantity is not less than 0.
        if ($quantity < 0) $quantity = 0;

        if (strtolower($trade_type) === 'sell') {
          $quantity *= -1;
        }

        // Only perform trades which have a quantity that is not 0.
        if ($quantity != 0) {
          $s_p = self::find_sp($stocks_portfolios, $ticker);
          $price = $s_p->stock->latest_price;
          $s_p->create_trade([
             'quantity'=>$quantity,
             'price'=>$price,
          ]);
        }
      }
    }
 
    redirect_to('/portfolios/'.current_user()->portfolios[0]->id.'#all-stocks-tab');
  }

  private function find_sp($stocks_portfolios, $ticker) {
    // Returns the stocks_portfolio associated with the $stocks_portfolios and $ticker
    foreach ($stocks_portfolios as $sp) {
      if ($sp->stock->ticker === $ticker) {
        return $sp;
      }
    }

    return null;
  }
}
