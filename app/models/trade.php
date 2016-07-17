<?php
class Trade extends ActiveRecord\Model implements JsonSerializable {
	static $belongs_to = array(
		array('stocks_portfolio')
	);

	static $after_create = array('adjust_stocks_portfolios');

  	static $validates_presence_of = array(
  		['stocks_portfolio_id'],
  		['quantity'],
  		['price']
  	);

  	public function validate() {
  		$total = $this->quantity * $this->price;

  		// Validate that the portfolio has enough cash if buying.
  		if ($this->quantity > 0 && $this->stocks_portfolio->portfolio->total_cash < $total) {
  			$this->errors->add('portfolio_cash', 'portfolio does not have enough cash');
  		}

  		// Validate that the portfolio contains enough as it is trying to sell.
  		if ($this->quantity < 0 && $this->stocks_portfolio->quantity_held < abs($this->quantity)) {
  			$this->errors->add('portfolio_quantity_held', 'can not short security');
  		}
  	}

	public function adjust_stocks_portfolios() {
		/* 
			After a trade, this adjusts the stocks_portfolio's quantity held, as well as the portfolio's cash.
		*/
		$stocks_portfolio = $this->stocks_portfolio;
		$stocks_portfolio->quantity_held += $this->quantity;
		$stocks_portfolio->save();

		$portfolio = $stocks_portfolio->portfolio;
		$portfolio->total_cash -= $this->quantity*$this->price;
		$portfolio->save();
	}

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}