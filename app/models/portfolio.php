<?php
class Portfolio extends ActiveRecord\Model implements JsonSerializable {

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}
