<?php
class UsersController extends Spark\BaseController {
  public function create() {
    $user_email = $this->params['user_email'];

    $user = new User();
    $user->email = $user_email;
    $user->password = $this->params['user_password'];
    
    if ($user->save()) {
      $this->locals = array('message' => 'All good');
    } else {
      $this->locals = array('message' => 'Bad');
    };

    $this->render("users/index.php");
  }

}