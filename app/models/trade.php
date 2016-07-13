<?php
class Trade extends ActiveRecord\Model implements JsonSerializable {
	static $belongs_to = array(
		array('stocks_portfolio')
	);

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}