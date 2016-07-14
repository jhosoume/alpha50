<?php
class PortfoliosController extends Spark\BaseController {
public function index() {
    //temporary locals assignment
    $this->locals = ['portfolio_id' => '1'];
    $this->render("portfolios/index.php");
  }

public function show() {
    $params = $this->params;
    $portfolio_id = $params['id'];
    $this->locals = ['portfolio_id' => $portfolio_id];
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

