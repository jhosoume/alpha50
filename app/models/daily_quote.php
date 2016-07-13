<?php
class DailyQuote extends ActiveRecord\Model implements JsonSerializable {
	static $belongs_to = array(
		array('stock')
	);

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}