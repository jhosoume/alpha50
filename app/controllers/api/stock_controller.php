<?php
namespace api;

class StocksController extends \Spark\BaseController {
	function index() {
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
    $join = 'LEFT JOIN stocks ON stock_id = stocks.id';
		$daily_quotes = \DailyQuote::all([
      'joins' => $join, 
      'conditions' => ['stocks.ticker = ?', $symbol],
      'limit' => $limit,
      ]);
		$half_hourly_quotes = \HalfHourlyQuote::all([
      'joins' => $join,
      'conditions' => ['stocks.ticker = ?', $symbol],
      'limit' => $limit,
      ]);

		$quotes = [$daily_quotes, $half_hourly_quotes];

		$this->render($quotes, ['content_type'=>'JSON', 'enable_cors'=>true]);
	}
}