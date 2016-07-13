<?php
class Trade extends ActiveRecord\Model implements JsonSerializable {
	

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}