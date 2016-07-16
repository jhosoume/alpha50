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
    $portfolio = \Portfolio::find($params['id']);
    $portfolio_equity = \PortfolioValuation::find_by_portfolio_id($portfolio->id)->value;
    $this->locals = ['portfolio' => $portfolio];
    //$portfolio = Portfolio::find($params['id']);

    $locals = [
      'portfolio_id'=>$portfolio->id,
      'portfolio'=> $portfolio,
      'stocks_portfolios'=>$portfolio->stocks_portfolios,
      'portfolio_equity_value' => $portfolio_equity
    ];

    $this->locals = $locals;

    $this->render('portfolios/index.php');
  }

  public function new() {
    $portfolio = new Portfolio();
    $stocks = \Stock::all();
    // index will need to be determined by admin user
    $portfolio_info = \Portfolio::find_by_sql(index_portfolio_info());
    $index_value = 0;
    foreach($portfolio_info as $stock) {
      $index_value += $stock->stock_value;
    };
    $this->locals = ['portfolio_info' => $portfolio_info, 'index_value' => $index_value ];
    $this->render('portfolios/new.php');
  }

  public function create() {
    $message = 'OK';
    $this->render($message, ['content_type'=>'JSON', 'enable_cors'=>true]);
  }
}

