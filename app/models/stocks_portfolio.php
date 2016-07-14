<?php
class StocksPortfolio extends ActiveRecord\Model implements JsonSerializable {
	static $has_many = array(
		array('trades')
	);

	static $belongs_to = array(
		array('stock'),
		array('portfolio')
	);

  	static $validates_presence_of = array(
  		['portfolio_id'],
  		['stock_id'],
  		['quantity_held']
  	);

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}