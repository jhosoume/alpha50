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
  $this->render('portfolios/new.php');
  }

}

