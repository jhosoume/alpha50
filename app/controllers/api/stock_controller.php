<?php
namespace api;

class StocksController extends \Spark\BaseController {
	function index() {
		$params = $this->params;
    self::request($params['request_type']);
  }

  function show() {
    $params = $this->params;
    $symbol = $params['symbol'];
    self::request($params['request_type'], $symbol);
  }

  private function request($type, $symbol = null) {
    switch ($type) {
      case 'latest_quotes':
      self::latest_quotes($symbol);
      break;

      case 'daily_quotes':
      $limit = $this->params['limit'];
      self::daily_quotes($symbol, $limit);
      break;
    }
  }

  private function latest_quotes($symbol) {
    if ($symbol === null) {
      $array = \Stock::all();
    } else {
      // TODO Single stock.
    }
    $this->render($array, ['content_type'=>'JSON', 'enable_cors'=>true]);
  }

  private function daily_quotes($symbol, $limit) {
    $array = array();
    $stocks = \Stock::all();

    if ($symbol === null) {
      foreach($stocks as $stock) {
        $quotes = \DailyQuote::all([
          'conditions'=>['stock_id = ?', $stock->id],
          'limit'=>$limit,
          'order'=>'id desc',
        ]);
        $array[$stock->ticker] = $quotes;
      }
      
    } else {
      // TODO Single stock.
    }
    $this->render($array, ['content_type'=>'JSON', 'enable_cors'=>true]);
  }
}
