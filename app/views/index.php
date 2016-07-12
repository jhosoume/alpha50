<p>This is the index!</p>
<div class='container'>
  <div class='row'>
    <div class='col s12'>
      <a href="#user-sign-up" class='btn modal-trigger'>Sign up</a> 
    </div>    
  </div>

  <div id="user-sign-up" class="modal">
    <div class="modal-content">
      <div class="row">
        <form class="col s12" action="/users" method='post'>
          <div class="row">
            <div class="input-field col s12">
              <input id="user_email" name='user_email' type="email" class="validate">
              <label for="email">Email</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="user_password" name='user_password' type="password" class="validate">
              <label for="password">Password</label>
            </div>
          </div>
          <button class="btn" type="submit" name='action'>
            Sign up
          </button>                
        </form>
      </div>
    </div>
  </div>  

</div>