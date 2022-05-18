<?php use Projet_Web_parcours\Assets\settings\Settings;?>
   <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Hascode</h3>
                    <p>Enter the hash code of your course</p>
                <!-- <form method="POST" action= <?php echo Settings::RACINE."Game/Game_controller/verify_hashcode"?>> -->
                  <div class="form-group">
                    <label>Hascode *</label>
                    <input type="text" id='inputHash' placeholder="hascode" name="hascode" class="form-control p_input">
                  </div>
                  <div class="text-center">
                    <button type="submit" id='searchHash' class="btn btn-success btn-block enter-btn">Play</button>
                  </div>
                  <p class="sign-up">Don't have an hashCode?<a href=<?php echo Settings::RACINE?>> Search Courses</a></p>
                <!-- </form> -->
                <?php
                  //Affiche les erreurs.
                  if(isset($error) && !empty($error)){
                      '<p style="color:darkred;font-style: italic;">'.$error.'</b>';
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
    <script src=<?php echo Settings::RACINE."Assets/settings/Settings.js"?>></script>
    <script src= <?php echo Settings::RACINE."Assets/Js/hash.js"?>></script>