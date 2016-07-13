<?php
class User extends ActiveRecord\Model {

  public function authenticate($password) {
    return password_verify($password, $this->password_hash);
  }

}
