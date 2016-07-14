<?php
class Trade extends ActiveRecord\Model implements JsonSerializable {
	static $belongs_to = array(
		array('stocks_portfolio')
	);

	static $after_create = array('adjust_stocks_portfolios_quantity_held');

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