<?php
class SessionsController extends BaseController {
  public function create() {
    $params = $this->params;

    $user = User::find_by_email($params['user_email']);
 
    if ($user && $user->authenticate($params['user_password'])) {

      session_start();
      $_SESSION['user_id'] = $user->id;
      $this->locals = array('message' => $_SESSION['user_id']);
      $this->render('users/index.php');

    } else {

      $this->locals = array('message' => "all bad");
      $this->render('users/index.php');

    }
  }

  public function destroy() {
    $_SESSION['user_id'] = null;

    $this->render('index.php');
  }
}