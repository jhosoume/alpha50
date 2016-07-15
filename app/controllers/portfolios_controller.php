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
    $portfolio_num= intval($params['id']) - 1;
    $portfolio = \Portfolio::find('all', ['order' => 'created_at asc', 'limit' => 1, 'offset' => $portfolio_num])[0];
    $this->locals = ['portfolio' => $portfolio];
    $this->render('portfolios/index.php');
  }

public function new() {
  $portfolio = new Portfolio();
  $sql_recent_half_hourly_quotes = sql_recent_half_hourly_quotes();
  $half_hourly_quotes = \HalfHourlyQuote::find_by_sql($sql_recent_half_hourly_quotes);
  $this->locals = ['quotes' => $half_hourly_quotes];
  $this->render('portfolios/new.php');
  }
}

