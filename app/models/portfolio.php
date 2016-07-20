<?php
class Portfolio extends ActiveRecord\Model implements JsonSerializable {
	static $after_create = array('create_all_stocks_portfolios', 'create_monkey_portfolio');
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

	public function create_monkey_portfolio() {
		if (!$this->is_monkey()) {
			$monkey_portfolio = $this->create_portfolio([
				'name'=>'Monkey '.$this->name,
				'total_cash'=>1000000,
				'user_id'=>$this->user_id,
			]);

			$monkey_portfolio->create_monkey_trades();
		}
	}

	public function is_monkey() {
		return $this->parent !== null;
	}

	private function create_monkey_trades() {
		$stocks_portfolios = StocksPortfolio::find('all', array('conditions'=>['portfolio_id = ?', $this->id], 'include' => array('stock')));
		$randoms = [];

		for($x = 0; $x < count($stocks_portfolios); $x++) {
			array_push($randoms, rand(1, 500));
		}
		$randoms_sum = array_sum($randoms);

		$x = 0;
		$total_cash = $this->total_cash;
		foreach ($stocks_portfolios as $sp) {
			$rand = $randoms[$x];
			$latest_price = $sp->stock->latest_price;
			$quantity = floor($rand/$randoms_sum*$total_cash/$latest_price);
			$sp->create_trade([
				'quantity'=>$quantity,
				'price'=>$latest_price
			]);
			$x++;
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

  public function get_value_at_date($date, $sector) {
    $column = $sector ? $sector : 'portfolio_value' ;
    if (date('Y-m-d') == $date) {
      return $val = 0;
    };
    $val = PortfolioValuation::first([
      'conditions' => ['portfolio_id = ? AND created_at LIKE ?',$this->id, $date."%"],
      ])->$column;
    return $val;
  }

  public function get_total_return_from($date) {
    if (date('Y-m-d') == $date) {
      return $total_return = 0;
    }
    $total_return = ($this::get_current_value()-$this::get_value_at_date($date, null))/$this::get_value_at_date($date, null);
    return $total_return;
  }

  public function get_comparable_index_valuation($column) {
    if (date('Y-m-d',strtotime($this->created_at)) == date('Y-m-d')) {
      return $index_valuation_data = [];
    }
    $created_date = date('Y-m-d', strtotime(PortfolioValuation::first('all', ['conditions' => ['portfolio_id = ?', $this->id],'order'=>'created_at asc'])->created_at));
    $admin = User::first(['conditions'=>['email = ?', 'admin@alpha50']]);
    $index_portfolio = Portfolio::first([
      'conditions'=>['user_id = ?', $admin->id],
      'include'=>['stocks_portfolios'=>['stock']],
    ]);

    $index_portfolio_valuations = PortfolioValuation::find('all',['conditions' => ['portfolio_id = ? AND created_at >= ?', $index_portfolio->id, $created_date], 'order'=>'created_at asc']);

    $index_valuation_data = [];
    $starting_capital = $this->get_value_at_date($created_date, $column);
    for ($i = 0; $i < count($index_portfolio_valuations); $i++) {
      $value = $index_portfolio_valuations[$i]->$column * $starting_capital / $index_portfolio_valuations[0]->$column;
      array_push($index_valuation_data, array(date('Y-m-d', strtotime($index_portfolio_valuations[$i]->created_at)), $value));
    }
    return $index_valuation_data;

  }

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}
