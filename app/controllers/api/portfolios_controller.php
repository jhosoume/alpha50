<?php
namespace api;


class PortfoliosController extends \Spark\BaseController {
  function new() {

    $portfolio_info = \Portfolio::find_by_sql(index_portfolio_info());
    $index_value = 0;
    foreach($portfolio_info as $stock) {
      $index_value += $stock->stock_value;
    };
    $locals = ['portfolio_info' => $portfolio_info, 'index_value' => $index_value];
    $this->render($locals, ['content_type'=>'JSON', 'enable_cors'=>true]);
  }


}