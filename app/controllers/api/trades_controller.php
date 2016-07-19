<?php
namespace api;

class TradesController extends \Spark\BaseController {
	function index() {
		$params = $this->params;
    $portfolio_id = $params['portfolio_id'];
    self::request($params['request_type'], $portfolio_id);
  }

  private function request($type, $portfolio_id) {
    switch ($type) {
      case 'trade_blotter_value':
      self::trade_blotter_value($portfolio_id);
      break;
    }
  }

  private function trade_blotter_value($portfolio_id) {
    $portfolio = \Portfolio::first([
      'conditions'=>['id=?', $portfolio_id],
      'include'=>['stocks_portfolios'=>['stock']],
    ]);
    $stocks_portfolios = $portfolio->stocks_portfolios;

    $start_date =  new \DateTime($portfolio->created_at);
    $end_date = new \DateTime(date('Y-m-d h:i:s', time()));
    $interval = \DateInterval::createFromDateString('1 day');
    $period = new \DatePeriod($start_date, $interval, $end_date);

    $trades = array();
    foreach($stocks_portfolios as $sp) {
      foreach($sp->trades as $trade) {
        array_push($trades, $trade);
      }
    }

    $chart_data = array();
    foreach($period as $date) {
      $formatted_date = $date->format("Y-m-d");
      $value = 0;
      foreach ($trades as $trade) {
        $trade_created_at = date("Y-m-d", strtotime($trade->created_at));
        if ($trade_created_at === $formatted_date) {
          $value += $trade->quantity * $trade->price;
        }
      }
      array_push($chart_data, [$formatted_date, $value]);
    }

    $this->render($chart_data, ['content_type'=>'JSON', 'enable_cors'=>true]);
  }
}
