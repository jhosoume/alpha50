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
}
