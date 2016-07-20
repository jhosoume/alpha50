<?php
namespace api;

class PortfoliosController extends \Spark\BaseController {

  function show() {
    $params = $this->params;
    $portfolio_id = $params['id'];
    $sector = isset($params['sector']) ? $params['sector'] : null;
    $limit = isset($params['limit']) ? $params['limit'] : null;
    if (isset($params['request_type'])) {
      self::request($portfolio_id, $params['request_type'], $sector, $limit);
    }
  }

  private function request($portfolio_id, $type, $sector, $limit) {
    switch ($type) {
    case 'historical_valuation':
      self::send_hist_valuation($portfolio_id, $sector, $limit);
      break;
    case 'current_valuation':
      self::send_curr_valuation($portfolio_id);
      break;
    }
  }

  private function send_hist_valuation($portfolio_id, $sector, $limit) {

    $user_portfolio_valuations = \PortfolioValuation::find('all',['conditions' => ['portfolio_id = ?', $portfolio_id], 'limit' => $limit]);

    $monkey_portfolio = \Portfolio::first(['conditions' => ['parent = ?', $portfolio_id]]);
    $monkey_portfolio_valuations = \PortfolioValuation::find('all',['conditions' => ['portfolio_id = ?', $monkey_portfolio->id], 'limit' => $limit]);

    $all_valuation_data = array();

    $user_valuation_data = array();
    $monkey_valuation_data = array();

    $column;
    if ($sector === 'all') {
      $column = 'portfolio_value';
    } else {
      $column=str_replace(" ","_",strtolower($sector));
    }

    for ($i = 0; $i < count($user_portfolio_valuations); $i++) {
      array_push($user_valuation_data, array(date('Y-m-d H:i:s', strtotime($user_portfolio_valuations[$i]->created_at)), $user_portfolio_valuations[$i]->$column));
      array_push($monkey_valuation_data, array(date('Y-m-d H:i:s', strtotime($monkey_portfolio_valuations[$i]->created_at)), $monkey_portfolio_valuations[$i]->$column));
    }

    $all_valuation_data['user'] = $user_valuation_data;
    $all_valuation_data['monkey'] = $monkey_valuation_data;

    $this->render($all_valuation_data, ['content_type'=>'JSON', 'enable_cors'=>true]);
  }

  private function send_curr_valuation($portfolio_id) {
    $portfolio_valuations = \PortfolioValuation::first('all', 
      ['conditions' => ['portfolio_id = ?', $portfolio_id],
      'order' => 'created_at DESC'
      ]);
    $portfolio = \Portfolio::first([
      'conditions'=>['id = ?', $portfolio_id],
      'include'=>['stocks_portfolios'=>['stock']],
    ]);

    $sector_values = array();
    $all_sectors = array();

    foreach($portfolio->stocks_portfolios as $s_p) {
      $sector = $s_p->stock->sector;
      if (!in_array($sector, $all_sectors)) {
        array_push($all_sectors, $sector);
      };
    };

    foreach($all_sectors as $sector) {
      $column = str_replace(" ", "_", strtolower($sector));
      $sector_values[$sector] = $portfolio_valuations->$column;
    };
    $sector_values['Cash'] = $portfolio->total_cash;
    asort($sector_values);

    $this->render($sector_values, ['content_type' => 'JSON', 'enable_cors'=>true]);
  }

}