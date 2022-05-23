<?php use Projet_Web_parcours\Assets\settings\Settings;?>
   <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="form-group">
                <a href=<?php echo Settings::RACINE?>>Back</a>
              </div>
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Login</h3>
                <form method="POST" action= <?php echo Settings::RACINE."Authentification/Authentification_controller/verify_signin"?>>
                  <div class="form-group">
                    <label>Username or email *</label>
                    <input type="text" placeholder="Username or email" name="usernameoremail" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Password *</label>
                    <input type="password" placeholder="password" name="password" class="form-control p_input">
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <!-- <label class="form-check-label">
                        <input type="checkbox" class="form-check-input"> Remember me </label> -->
                    </div>
                    <a href=<?php echo Settings::RACINE."Authentification/Authentification_controller/displayForgot"?> class="forgot-pass">Forgot password</a>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                  </div>
                  <div class="d-flex">
                    <!-- <button class="btn btn-facebook me-2 col">
                      <i class="mdi mdi-facebook"></i> Facebook </button>
                    <button class="btn btn-google col">
                      <i class="mdi mdi-google-plus"></i> Google plus </button> -->
                  </div>
                  <p class="sign-up">Don't have an Account?<a href= <?php echo Settings::RACINE."Authentification/Authentification_controller/displaySignup"?>> Sign Up</a></p>
                </form>
                <?php
                  //Affiche les oublies
                  if(isset($errors) && !empty($errors)){
                    foreach($errors as $attribute => $value){
                      echo is_int($attribute)? '<p style="color:darkred;font-style: italic;">Vous avez oublié de renseigner votre <b>'.$value.'</b>' :
                      '<p style="color:darkred;font-style: italic;">Veuillez réessayer : ' .$attribute.' incorrect</p>';
                    }
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src= <?php echo Settings::RACINE."template/assets/vendors/js/vendor.bundle.base.js"?>></script>
    <script src= <?php echo Settings::RACINE."template/assets/js/misc.js"?>></script>