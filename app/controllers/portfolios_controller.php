<?php
class PortfoliosController extends Spark\BaseController {
  public function index() {
    // if user is not logged in, it redirects to main index
    if (!current_user()) {
      redirect_to('/');
    } else {
      // Redirects user to either creating a new portfolio, or their first.
      if (count(current_user()->portfolios) == 0) {
        redirect_to('/portfolios/new');
      } else {
        redirect_to('/portfolios/'.current_user()->portfolios[0]->id);
      }
    }
  }

  public function show() {
    $admin = User::first(['conditions'=>['email = ?', 'admin@alpha50']]);
    $params = $this->params;
    $portfolio = Portfolio::first([
      'conditions'=>['id = ?', $params['id']],
      'include'=>['stocks_portfolios'=>['stock']],
    ]);
    $index_portfolio = Portfolio::first([
      'conditions'=>['user_id = ?', $admin->id],
      'include'=>['stocks_portfolios'=>['stock']],
    ]);
    $monkey_portfolio = Portfolio::first([
      'conditions'=>['parent = ?', $portfolio->id],
      'include'=>['stocks_portfolios'=>['stock']],
    ]);
    $all_portfolios = Portfolio::find('all',['conditions' => ['user_id = ? AND parent IS NULL', current_user()->id]]); 
    $portfolio->sort_by_quantity_held();
    $all_trades = array();

    foreach($portfolio->stocks_portfolios as $sp) {
      foreach($sp->trades as $trade) {
        array_push($all_trades, $trade);
      }
    }

    usort($all_trades, function($a, $b) {
      return $a->created_at < $b->created_at ? 1 : -1;
    });

    $sectors = array();
    foreach($portfolio->stocks_portfolios as $s_p):
      $sector = $s_p->stock->sector;
      if (!in_array($sector, $sectors)) {
        array_push($sectors, $sector);
      };
    endforeach;

    $locals = [
      'portfolio_id'=>$portfolio->id,
      'portfolio'=> $portfolio,
      'stocks_portfolios'=>$portfolio->stocks_portfolios,
      'portfolio_equity' => $portfolio->current_value - $portfolio->total_cash,
      'portfolio_value' => $portfolio->current_value,
      'all_portfolios' => $all_portfolios,
      'trades' => $all_trades,
      'sectors' => $sectors,
      'index_portfolio' => $index_portfolio,
      'monkey_portfolio' => $monkey_portfolio,
      'index_stocks_portfolios' => $index_portfolio->stocks_portfolios,
      'monkey_stocks_portfolios' =>$monkey_portfolio->stocks_portfolios,
      'index_portfolio_value' => $index_portfolio->current_value,
      'monkey_portfolio_value' => $monkey_portfolio->current_value,
    ];

    $this->locals = $locals;
    $this->render('portfolios/index.php');
  }

  public function _new() {
    $admin = User::first(['conditions'=>['email = ?', 'admin@alpha50']]);
    $index_portfolio = Portfolio::first([
      'conditions'=>['user_id = ?', $admin->id],
      'include'=>['stocks_portfolios'=>['stock']],
    ]);
    $all_portfolios = Portfolio::find('all',['conditions' => ['user_id = ?', current_user()->id]]);

    $index_portfolio->sort_by_ticker();

    $index_value = $index_portfolio->get_current_value();

    $this->locals = ['index_portfolio' => $index_portfolio, 'index_value' => $index_value, 'all_portfolios' => $all_portfolios ];
    $this->render('portfolios/new.php');
  }

  public function create() {
    $params = $this->params;
    $keys = array_keys($params);
    $portfolio = current_user()->create_portfolio([
      'name'=>$params['name'],
      'total_cash'=>1000000,
    ]);

    $stocks_portfolios = StocksPortfolio::find('all', array('conditions'=>['portfolio_id = ?', $portfolio->id], 'include' => array('stock')));

    for($i = 0; $i < count($keys); $i++) {
      $key = $keys[$i];
      if (strpos($key, 'ticker') === 0) {
        $ticker = $params[$key];
        $quantity = intval($params[$ticker.'TradeQuantity']);

        // Make sure user submitted quantity is not less than 0.
        if ($quantity < 0) $quantity = 0;

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
 
    redirect_to('/portfolios/'.$portfolio->id.'#all-stocks-tab');
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

