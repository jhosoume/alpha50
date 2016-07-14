<?php
namespace api;


class StocksController extends \Spark\BaseController {
	function index() {
		$params = $this->params;
    $limit = isset($params['limit']) ? $params['limit'] : null;
    if (isset($params['request_type'])) {
      self::request(null, $params['request_type'], $limit);
    }
  }

  function show() {
    $params = $this->params;
    $symbol = $params['symbol'];
    $limit = isset($params['limit']) ? $params['limit'] : null;
    if (isset($params['request_type'])) {
      self::request($symbol, $params['request_type'], $limit);
    }
  }

  private function request($symbol, $type, $limit) {
    switch ($type) {
      case 'quotes':
      self::send_quotes($symbol, $limit);
      break;
    }
  }

  private function send_quotes($symbol, $limit) {

    $sql_recent_daily_quotes = sql_recent_daily_quotes();
    $sql_recent_half_hourly_quotes = sql_recent_half_hourly_quotes();
 
    if ($symbol === null) {
      $daily_quotes = \DailyQuote::find_by_sql($sql_recent_daily_quotes);
      $half_hourly_quotes = \HalfHourlyQuote::find_by_sql($sql_recent_half_hourly_quotes);   
    } else {
      $join = 'LEFT JOIN stocks ON stock_id = stocks.id';
      $conditions = [
        'limit' => $limit, 
        'joins' => $join,
        'conditions' => ['stocks.ticker = ?', $symbol]
        ];
      $daily_quotes = \DailyQuote::all($conditions);
      $half_hourly_quotes = \HalfHourlyQuote::all($conditions);  
    }

    $quotes = ['daily'=>$daily_quotes, 'half_hourly'=>$half_hourly_quotes];

    $this->render($quotes, ['content_type'=>'JSON', 'enable_cors'=>true]);


  }


}