<?php
class StocksPortfolio extends ActiveRecord\Model implements JsonSerializable {
	static $has_many = array(
		array('trades')
	);

	public function validate() {		
		if ($this->quantity_held < 0) {
			$this->errors->add('quantity_held', 'can not be less than 0');
		}
	}

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