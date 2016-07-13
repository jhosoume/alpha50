<?php
namespace api;

class StocksController extends \BaseController {
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

    $sql_recent_daily_quotes = '
      SELECT a.*, c.*
      FROM daily_quotes a
      LEFT JOIN (
          SELECT id, MAX(date) AS MaxDate
          FROM daily_quotes
          GROUP BY id
      ) b ON a.id = b.id AND a.date = b.MaxDate 
      LEFT JOIN (
        SELECT *
          FROM stocks
      ) c ON a.stock_id = c.id
      ORDER BY a.date 
      DESC LIMIT 50;';

    $sql_recent_half_hourly_quotes = '
      SELECT a.*, c.*
      FROM half_hourly_quotes a
      LEFT JOIN (
          SELECT id, max(datetime) AS MaxDatetime
          FROM half_hourly_quotes
          GROUP BY id
      ) b on a.id = b.id and a.datetime = b.MaxDatetime
      LEFT JOIN (
        SELECT *
          FROM stocks
      ) c ON a.stock_id = c.id
      ORDER BY a.datetime 
      DESC LIMIT 50;';    
 
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