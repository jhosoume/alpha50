<?php
class StocksPortfolio extends ActiveRecord\Model implements JsonSerializable {
	static $has_many = array(
		array('trades')
	);

	static $belongs_to = array(
		array('stock'),
		array('portfolio')
	);

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}