<?php
class Stock extends ActiveRecord\Model implements JsonSerializable {
	static $has_many = array(
		array('daily_quotes'),
		array('half_hourly_quotes'),
		array('stocks_portfolios')
	);

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}