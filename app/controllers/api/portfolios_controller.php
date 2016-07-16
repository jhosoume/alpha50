<?php
namespace api;

class PortfoliosController extends \Spark\BaseController {
public function create() {
    $data = json_decode($this->params['portfolio']);

    $portfolio_name = $data->info->name;
    $trades = $data->trades;
    $portfolio = current_user()->create_portfolio(['name' => $portfolio_name, 'cash' => 999999]);
    $stocks_portfolios = \StocksPortfolio::find('all', array('conditions'=>['portfolio_id = ?', $portfolio->id], 'include' => array('stock')));
    foreach ($trades as $trade) {
      $ticker = $trade->ticker;
      $quantity = intval($trade->quantity);
      if ($quantity < 0) $quantity = 0;

      if ($quantity != 0) {
        $s_p = self::find_sp($stocks_portfolios, $ticker);
        $price = $s_p->stock->latest_price;
        $s_p->create_trade([
           'quantity'=>$quantity,
           'price'=>$price,
          ]);
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