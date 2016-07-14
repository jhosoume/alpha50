<head>
  <nav class="top-nav grey darken-2">
    <div class="nav-wrapper">
      <a href="/" class='brand-logo'>Alpha50</a>
      <ul class='right hide-on-med-and-down'>
        <li><a href="">About us</a></li>
        <li><a href="">Why join?</a></li>
        <li><a href="">Features</a></li>
        <?php if ($_SESSION['user_id']) {
          echo('<li><a href="#user-log-out" class="btn modal-trigger">Log out</a></li>');
        } else { 
          echo('<li><a href="#user-log-in" class="btn modal-trigger">Log in</a></li>');
        } ?>
      </ul>
      <ul id="slide-out" class="side-nav">
        <?php if ($_SESSION['user_id']) {
            echo('<li><a href="#user-log-out" class="btn modal-trigger">Log out</a></li>');
          } else { 
            echo('<li><a href="#user-log-in" class="btn modal-trigger">Log in</a></li>');
          } ?>
        <li><a href="#!">About Us</a></li>
        <li><a href="#!">Why join?</a></li>
        <li><a href="#!">Features</a></li>
      </ul>
      <a href="#" data-activates="slide-out" class="button-collapse trigger-side-nav"><i class="material-icons">menu</i></a>

    </div>
  </nav>
        <div id="user-log-in" class="modal">
          <div class="modal-content">
            <div class="row">
              <form class="col s12" action='/sessions' method='post'>
                <div class="row">
                  <div class="input-field col s12">
                    <input id="user_email" type="email" name='user_email' class="validate">
                    <label for="user_email">Email</label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                    <input id="user_password" type="password" name='user_password' class="validate">
                    <label for="user_password">Password</label>
                  </div>
                </div>
                <button class="btn" type="submit" name="action">
                  Log in
                </button>                
              </form>
            </div>
          </div>
      </div>
      <div id="user-log-out" class="modal">
          <div class="modal-content">
            <div class="row">
              <form class="col s12" action='/sessions' method='post'>
                <div class="row">
                  <div class="input-field col s12">
                    <p>Sure?</p>
                  </div>
                </div>
                <input type='hidden' name="_method" value="DELETE">
                <input type='submit' value="Log out">               
              </form>
            </div>
          </div>
      </div>
</head>