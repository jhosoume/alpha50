<?php
class Portfolio extends ActiveRecord\Model implements JsonSerializable {
	static $belongs_to = array(
		array('user'),
		array('parent_portfolio', 'class_name' => 'Portfolio')
	);

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}
