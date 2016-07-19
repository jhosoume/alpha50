<?php
class Portfolio extends ActiveRecord\Model implements JsonSerializable {
	static $after_create = array('create_all_stocks_portfolios');
	static $has_many = array(
		array('stocks_portfolios'),
    array('portfolio_valuations'),
	);

	static $has_one = array(
		array('portfolio', 'foreign_key' => 'parent')
	);

	static $belongs_to = array(
		array('user'),
		array('parent_portfolio', 'class_name' => 'Portfolio', 'foreign_key' => 'parent')
	);

	static $validates_presence_of = array(
		['name'],
		['user_id'],
		['total_cash']
	);

	public function create_all_stocks_portfolios() {
		$stocks = Stock::find('all', ['order'=>'ticker asc']);

		foreach($stocks as $stock) {
			StocksPortfolio::create([
				'stock_id'=>$stock->id,
				'portfolio_id'=>$this->id,
				'quantity_held'=>0,
			]);
		}
	}

	public function sort_by_ticker() {
		$sp = &$this->stocks_portfolios;
	    usort($sp, function($a, $b) {
	      return $a->stock->ticker < $b->stock->ticker ? -1 : 1;
	    });
	}

	public function sort_by_quantity_held() {
		$sp = &$this->stocks_portfolios;
	    usort($sp, function($a, $b) {
	    	if ($a->quantity_held == $b->quantity_held) {
	    		return $a->stock->ticker < $b->stock->ticker ? -1 : 1;
	    	}
	      	return $a->quantity_held > $b->quantity_held ? -1 : 1;
	    });
	}

  public function get_current_value() {
    $val = $this->total_cash;
    $stocks_portfolios = StocksPortfolio::find('all', array('conditions'=>['portfolio_id = ?', $this->id], 'include' => array('stock')));
    foreach ($stocks_portfolios as $sp) {
      $val += $sp->quantity_held * $sp->stock->latest_price;
    }
    return $val;
  }

  public function get_value_at_date($date) {
    $val = PortfolioValuation::first([
      'conditions' => ['portfolio_id = ? AND created_at LIKE ?',$this->id, $date."%"],

      ])->portfolio_value;
    return $val;
  }

  public function get_total_return_from($date) {
    $total_return = ($this::get_current_value()-$this::get_value_at_date($date))/$this::get_value_at_date($date);
    return $total_return;
  }

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}
