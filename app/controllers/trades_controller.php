<?php
class TradesController extends Spark\BaseController {
  public function create() {
    $params = $this->params;
    $keys = array_keys($params);
    $portfolio = Portfolio::find($params['portfolioId']);
    $stocks_portfolios = $portfolio->stocks_portfolios;

    for($i = 0; $i < count($keys); $i++) {
      $key = $keys[$i];
      if (strpos($key, 'ticker') === 0) {
        $ticker = $params[$key];
        $trade_type = $params[$ticker.'TradeType'];
        $quantity = intval($params[$ticker.'TradeQuantity']);
        if (strtolower($trade_type) === 'sell') {
          $quantity *= -1;
        }

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
