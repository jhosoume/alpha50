<?php
class User extends ActiveRecord\Model implements JsonSerializable {
	static $has_many = array(
		array('portfolios')
	);

	public function jsonSerialize()
    {
        return json_decode($this->to_json());
    }

  public function authenticate($password) {
    return password_verify($password, $this->password_hash);
  }

}
