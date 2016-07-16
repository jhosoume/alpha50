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
    $portfolio = Portfolio::find($params['id']);
    $this->locals = ['portfolio' => $portfolio];

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
    // index will need to be determined by admin user
    $portfolio_info = \Portfolio::find_by_sql(index_portfolio_info());
    $index_value = 0;
    foreach($portfolio_info as $stock) {
      $index_value += $stock->stock_value;
    };
    $this->locals = ['portfolio_info' => $portfolio_info, 'index_value' => $index_value ];
    $this->render('portfolios/new.php');
  }
}

