<?php
class Trade extends ActiveRecord\Model implements JsonSerializable {
	static $belongs_to = array(
		array('stocks_portfolio')
	);

	static $after_create = array('adjust_stocks_portfolios_quantity_held');

  	static $validates_presence_of = array(
  		['stocks_portfolio_id'],
  		['quantity'],
  		['price']
  	);

  	public function validate() {
  		$total = $this->quantity * $this->price;

  		// Validate that the portfolio has enough cash if buying.
  		if ($this->quantity > 0 && $this->stocks_portfolio->portfolio->cash < $total) {
  			$this->errors->add('portfolio_cash', 'portfolio does not have enough cash');
  		}

  		// Validate that the portfolio contains enough as it is trying to sell.
  		if ($this->quantity < 0 && $this->stocks_portfolio->quantity_held < $this->quantity) {
  			$this->errors->add('portfolio_quantity', 'can not short security');
  		}
  	}

	public function adjust_stocks_portfolios_quantity_held() {
		/* 
			This adjusts the stocks_portfolio's quantity held.
			For ex, Johns portfolio has no aapl stock. It then buys 10 aapl.
			This callback fires, and John/aapl stocks_portfolio quantity_held is now 10.
		*/
		$stocks_portfolio = $this->stocks_portfolio;
		$stocks_portfolio->quantity_held += $this->quantity;
		$stocks_portfolio->save();
	}

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}