<?php
class Stock extends ActiveRecord\Model implements JsonSerializable {
	static $has_many = array(
		array('daily_quotes'),
		array('half_hourly_quotes')
	);

  static $has_many = array(array('daily_quotes'), array('half_hourly_quotes'));


	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}