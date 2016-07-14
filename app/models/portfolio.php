<?php
class Portfolio extends ActiveRecord\Model implements JsonSerializable {
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

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}
