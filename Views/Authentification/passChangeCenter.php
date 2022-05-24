<?php use Projet_Web_parcours\Assets\settings\Settings;?>
   <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <form method="POST" action= <?php echo Settings::RACINE."Authentification/Authentification_controller/verify_change"?>>
                  <div class="form-group" id="emailAdd">
                    <input type="email" name="email" value= <?php echo $email?> class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>New password</label>
                    <input type="password" id="password" placeholder="Password" name="password" minlength="8" maxlength="40" pattern="((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*])(?!.*[()--+={}\[\]|&quot\\:;'<>,.?/_₹~`\s]).{8,40})" class="form-control p_input">
                    <div id="password-error" class="zone-error"></div>
                  </div>
                  <div class="form-group">
                    <label>Confirm password</label>
                    <input type="password" id="passwordConfirm" placeholder="Password" name="passwordConfirm" minlength="8" maxlength="40" pattern="((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*])(?!.*[()--+={}\[\]|&quot\\:;'<>,.?/_₹~`\s]).{8,40})" class="form-control p_input">
                    <div id="password-error_confirm" class="zone-error"></div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Confirm</button>
                  </div>
                </form>
                <p style="color:darkred;font-style: italic;" id="err">
                  <?php
                    //Affiche les oublies.
                    if(isset($errors) && !empty($errors)){
                      echo $errors;
                    }
                  ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src= <?php echo Settings::RACINE."template/assets/vendors/js/vendor.bundle.base.js"?>></script>
    <script src= <?php echo Settings::RACINE."template/assets/js/misc.js"?>></script>
    <script src= <?php echo Settings::RACINE."Assets/Js/changePass.js"?>></script>