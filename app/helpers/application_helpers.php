<?php
  function current_user() {
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null)  {
      return User::find($_SESSION['user_id']);
    };
    return false;
  }

  function redirect_to($path) {
  	header('Location: ' . $path);
  }

  function format_date($timestamp) {
  	return date("F j, Y, g:i a", strtotime($timestamp));
  }