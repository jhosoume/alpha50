<?php
class PortfolioValuation extends ActiveRecord\Model implements JsonSerializable {

  static $belongs_to = array(
    array('portfolio', 'foreign_key' => 'parent'),
  );

  public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }
}