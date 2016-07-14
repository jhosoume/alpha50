<?php
class User extends ActiveRecord\Model implements JsonSerializable {
	static $has_many = array(
		array('portfolios')
	);


  static $validates_presence_of = array(
    ['email'],
  );

  public function authenticate($password) {
    return password_verify($password, $this->password_hash);
  }

  public function jsonSerialize()
  {
    return json_decode($this->to_json());
  }

}
