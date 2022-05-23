<?php use Projet_Web_parcours\Assets\settings\Settings;?>
   <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <form method="POST" action= <?php echo Settings::RACINE."Authentification/Authentification_controller/verify_forgot"?>>
                  <div class="form-group">
                    <label>Email *</label>
                    <input type="email" placeholder="Email" name="email" class="form-control p_input">
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Reset password</button>
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                    <a href=<?php echo Settings::RACINE."Authentification/Authentification_controller/displaySignin"?> class="forgot-pass">Back</a>
                  </div>
                </form>
                <?php
                  //Affiche les oublies.
                  if(isset($errors) && !empty($errors)){
                      echo '<p style="color:darkred;font-style: italic;">'.$errors.'</p>';
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