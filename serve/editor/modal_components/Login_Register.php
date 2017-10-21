<div class="rglg-title">
  <div class="rg-title">Register</div>
  <div class="lg-title">Login</div>
  <div style="clear: both;"></div>
</div>
@row
  @half
    <div class="register">
      <form id="register-form" method="post" data-type="register">
        <div class="form_container">
          <div class="_container">
            <span class="label">EMAIL</span>
            <input type="email" name="rg_email" class="email" />
          </div>
          <div class="_container">
            <span class="label">PASSWORD</span>
            <input type="password" name="rg_password" class="password" />
          </div>
          <div class="_container">
            <span class="label">PASSWORD AGAIN</span>
            <input type="password" name="rg_password_auth" class="password-auth" />
          </div>
          <div class="_container">
            <input type="submit" name="submit" value="Register" />
          </div>
        </div>
      </form>
    </div>
  @half-connection
    <div class="login">
      <form id="login-form" method="post" data-type="login">
        <div class="form_container">
          <div class="_container">
            <span class="label">EMAIL</span>
            <input type="email" name="lg_email" class="email" />
          </div>
          <div class="_container">
            <span class="label">PASSWORD</span>
            <input type="password" name="lg_password" class="password" />
          </div>
          <div class="_container">
            <input type="submit" name="submit" value="Login" />
          </div>
        </div>
      </form>
    </div>
  @//
@//
@row
  <div style="height: 1px; width: 100%; background: #eceeef;"></div>
  <div class="ggl-signin">
    <!-- google platform - for sign in -->
    <div class="text">Or sign in with your Google account:</div>
    <div class="g-signin2" data-onsuccess="Google_Login_Controller"></div>
    <meta name="google-signin-client_id" content="425983720452-i8go5du2japrogjjkgdt1k7pjgkvftcl.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
  </div>
@//
