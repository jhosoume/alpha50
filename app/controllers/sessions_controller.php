<?php
class SessionsController extends Spark\BaseController {
  public function create() {
    $params = $this->params;
    $user = User::find_by_email($params['user_email']);
 
    if ($user && $user->authenticate($params['user_password'])) {
      // Logged in.
      $_SESSION['user_id'] = $user->id;
      $this->locals = array('user' => $user);

      if (count(current_user()->portfolios) == 0) {
        redirect_to('/portfolios/new');
      } else {
        redirect_to('/portfolios/'.current_user()->portfolios[0]->id);
      }
    } else {
      // Login doesn't match.
      $this->locals = array('message' => "Login Failed");
      redirect_to('/');
    }
  }

  public function destroy() {
    // Logged out.
    $_SESSION['user_id'] = null;
    redirect_to('/');
  }
}