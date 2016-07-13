<?php
class UsersController extends BaseController {
  public function create() {
    $user_email = $this->params['user_email'];
    $password_hash = password_hash($this->params['user_password'], PASSWORD_DEFAULT);

    $user = new User();
    $user->email = $user_email;
    $user->password_hash = $password_hash;
    
    if ($user->save()) {
      $this->locals = array('message' => 'All good');
    } else {
      $this->locals = array('message' => 'Bad');
    };

    $this->render("users/index.php");
  }

}