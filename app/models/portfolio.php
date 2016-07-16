<?php
class Portfolio extends ActiveRecord\Model implements JsonSerializable {
	static $after_create = array('create_all_stocks_portfolios');
	static $has_many = array(
		array('stocks_portfolios')
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
		['cash']
	);

	public function create_all_stocks_portfolios() {
		$stocks = Stock::all();

		foreach($stocks as $stock) {
			StocksPortfolio::create([
				'stock_id'=>$stock->id,
				'portfolio_id'=>$this->id,
				'quantity_held'=>0,
			]);
		}
	}

  public function get_current_value() {
    $val = $this->cash;
    $stocks_portfolios = StocksPortfolio::find('all', array('conditions'=>['portfolio_id = ?', $this->id], 'include' => array('stock')));
    foreach ($stocks_portfolios as $sp) {
      $val += $sp->quantity_held * $sp->stock->latest_price;
    }
    return $val;
  }

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}
