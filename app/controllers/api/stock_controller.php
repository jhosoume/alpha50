<?php
namespace api;

class StocksController extends \BaseController {
	function index() {
		$params = $this->params;
		$symbol = $params['symbol'];
		if (isset($params['request_type'])) {
			self::request($symbol, $params['request_type']);
		}
	}

	private function request($symbol, $type) {
		switch ($type) {
			case 'quotes':
			self::send_quotes($symbol);
			break;
		}
	}

	private function send_quotes($symbol) {
		$stock = \Stock::find('first', ['conditions'=> ['ticker = ?', $symbol]]);
		$daily_quotes = $stock->daily_quotes;
		$hourly_quotes = $stock->daily_quotes;

		$quotes = [$daily_quotes, $hourly_quotes];

		$this->render($quotes, ['content_type'=>'JSON', 'enable_cors'=>true]);
	}
}