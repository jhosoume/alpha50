<?php
namespace api;

class PortfoliosController extends \Spark\BaseController {

  function show() {
    $params = $this->params;
    $portfolio_id = $params['id'];
    $sector = $params['sector'];
    $limit = isset($params['limit']) ? $params['limit'] : null;
    if (isset($params['request_type'])) {
      self::request($portfolio_id, $params['request_type'], $sector, $limit);
    }
  }

  private function request($portfolio_id, $type, $sector, $limit) {
    switch ($type) {
      case 'historical_valuation':
      self::send_valuation($portfolio_id, $sector, $limit);
      break;
    }
  }

  private function send_valuation($portfolio_id, $sector, $limit) {

    $portfolio_valuations = \PortfolioValuation::find('all',['conditions' => ['portfolio_id = ?', $portfolio_id], 'limit' => $limit]);
    $valuation_data = array();

    switch ($sector) {
      case 'all':
      foreach($portfolio_valuations as $valuation) {
        array_push($valuation_data, array(date('Y-m-d H:i:s', strtotime($valuation->created_at)), $valuation->portfolio_value));
      }
      break;
    }

    $this->render($valuation_data, ['content_type'=>'JSON', 'enable_cors'=>true]);


  }


}