<?php
  function current_user() {
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null)  {
      return User::find($_SESSION['user_id']);
    };
    return false;
  }