<?php
class Stock extends ActiveRecord\Model implements JsonSerializable {
	static $has_many = array(
		array('daily_quotes'),
		array('half_hourly_quotes'),
		array('stocks_portfolios')
	);

  	static $validates_presence_of = array(
  		['name'],
  		['ticker'],
  		['sector'],
  		['market_cap']
  	);

	public function jsonSerialize()
    {
        return json_decode($this->to_json([
          'except'=>'id'
        ]));
    }
}