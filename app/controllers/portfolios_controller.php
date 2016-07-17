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
    $params = $this->params;
    $portfolio = Portfolio::first([
      'conditions'=>['id = ?', $params['id']],
      'include'=>['stocks_portfolios'=>['stock']],
    ]);
    $portfolio->sort_by_quantity_held();

    $locals = [
      'portfolio_id'=>$portfolio->id,
      'portfolio'=> $portfolio,
      'stocks_portfolios'=>$portfolio->stocks_portfolios,
      'portfolio_equity' => $portfolio->current_value - $portfolio->cash,
      'portfolio_value' => $portfolio->current_value
    ];

    $this->locals = $locals;
    $this->render('portfolios/index.php');
  }

  public function new() {
    $admin = User::first(['conditions'=>['email = ?', 'admin@alpha50']]);
    $index_portfolio = Portfolio::first([
      'conditions'=>['user_id = ?', $admin->id],
      'include'=>['stocks_portfolios'=>['stock']],
    ]);

    $index_portfolio->sort_by_ticker();

    $index_value = $index_portfolio->get_current_value();

    $this->locals = ['index_portfolio' => $index_portfolio, 'index_value' => $index_value ];
    $this->render('portfolios/new.php');
  }

  public function create() {
    $data = json_decode($this->params['portfolio']);

    // $portfolio_name = $data->info->name;
    // $trades = $data->trades;
    // $portfolio = current_user()->create_portfolio(['name' => $portfolio_name, 'cash' => 999999]);
    // $stocks_portfolios = \StocksPortfolio::find('all', array('conditions'=>['portfolio_id = ?', $portfolio->id], 'include' => array('stock')));
    // foreach ($trades as $trade) {
    //   $ticker = $trade->ticker;
    //   $quantity = intval($trade->quantity);
    //   if ($quantity < 0) $quantity = 0;

    //   if ($quantity != 0) {
    //     $s_p = self::find_sp($stocks_portfolios, $ticker);
    //     $price = $s_p->stock->latest_price;
    //     $s_p->create_trade([
    //        'quantity'=>$quantity,
    //        'price'=>$price,
    //       ]);
    //   }       
    // }
    //   redirect_to('/portfolios/'.current_user()->portfolios[0]->id.'#all-stocks-tab');
    render($data, ['content_type'=>'json'])
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

