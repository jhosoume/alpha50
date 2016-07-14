<?php
class User extends ActiveRecord\Model implements JsonSerializable {
  // Plain text - only used on user creation.
  private $plain_text_password;

  // Function for active record to get the plain text password on validations.
  protected function get_plain_text_password() {
    return $this->plain_text_password;
  }

  static $has_many = array(
  	array('portfolios')
  );

  static $validates_presence_of = array(
    ['email'],
    ['plain_text_password', 'on'=>'create']
  );

  static $validates_size_of = array(
    ['plain_text_password', 'on'=>'create', 'minimum'=>8, 'too_short'=>'must be at least 8 characters long']
  );

  static $after_create = array('nullify_password');

  // ActiveRecord attribute setter. User passwords are always set with user->password = "password".
  public function set_password($plain_text) {
    $this->plain_text_password = $plain_text; // Only for save validation
    $this->password_hash = password_hash($plain_text, PASSWORD_DEFAULT);
  }

  public function nullify_password() {
    $this->plain_text_password = null;
  }

  public function authenticate($password) {
    return password_verify($password, $this->password_hash);
  }

  public function jsonSerialize()
  {
    return json_decode($this->to_json());
  }

}
