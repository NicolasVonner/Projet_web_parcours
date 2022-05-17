<?php use Projet_Web_parcours\Assets\settings\Settings;?>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Register</h3>
                <form method="POST" action=<?php echo Settings::RACINE."Authentification/Authentification_controller/verify_signup"?>>
                 <div class="form-group">
                    <label>First name</label>
                    <input type="text" placeholder="First name" name="firstname" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Last name</label>
                    <input type="text" placeholder="Last name" name="lastname" class="form-control p_input">
                  </div>
                 <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="email@gmail.com" name="email" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Username </label>
                    <input type="text" id ="username" placeholder="Username" name="username" minlength="3" maxlength="20" pattern="((?!.*[!@#\$%\^&\*()--+={}\[\]|&quot\\:;'<>,.?/_₹~`\s]).{3,20})" class="form-control p_input">
                    <div id="username-error" class="zone-error"></div>
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" placeholder="Password" name="password" minlength="8" maxlength="40" pattern="((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*])(?!.*[()--+={}\[\]|&quot\\:;'<>,.?/_₹~`\s]).{8,40})" class="form-control p_input">
                   <div id="password-error" class="zone-error"></div>
                  </div>
                  <div class="form-group">
                    <label>Birthday</label>
                    <input type="date" id="start" name="dateNaissance"
                    value="2018-07-22"
                    min="1962-01-01" max=<?php echo date("Y-m-d")?> class="form-control p_input"> 
                  </div>
                  <div class="form-group">
                    <div class="dropdown">
                          <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuOutlineButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Select your avatar </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton2" style="margin-bottom: 0; overflow: auto; height: 110px;">                    
                              <?php
                                $dir ='Assets\Images\faces';
                                  // Ouvre un dossier bien connu, et liste tous les fichiers
                                  if (is_dir($dir)) {
                                    if ($dh = opendir($dir)) {
                                        while (($file = readdir($dh)) !== false) {
                                          if($file != "." && $file != "..")
                                          echo "<img class='img-sm avatar' src= '".Settings::RACINE."Assets/Images/faces/".$file."' alt=''>";
                                        }
                                        closedir($dh);
                                    }
                                  }
                              ?>                  
                            </div>
                          <img src= <?php echo Settings::RACINE."Assets/Images/faces/face8.jpg"?> alt="image" id="avatar-preview" class="rounded-circle"/>
                          
                    </div>
                    <input type="text" id="form-avatar" value="face8.jpg" name="avatar" hidden>
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input"> Remember me </label>
                    </div>
                    <a href="#" class="forgot-pass">Forgot password</a>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                  </div>
                  <div class="d-flex">
                    <button class="btn btn-facebook col me-2">
                      <i class="mdi mdi-facebook"></i> Facebook </button>
                    <button class="btn btn-google col">
                      <i class="mdi mdi-google-plus"></i> Google plus </button>
                  </div>
                  <p style="font-style: italic;" class="sign-up text-center">Already have an Account?<a href=<?php echo Settings::RACINE."Authentification/Authentification_controller/displaySignin"?>> Sign In</a></p>
                  <p class="terms">By creating an account you are accepting our<a href="#"> Terms & Conditions</a></p>
                </form>
                <?php
                  //Affiche les oublies
                  if(isset($errors) && !empty($errors)){
                    foreach($errors as $attribute => $value){
                      $value = mapAttribut($value);
                      echo is_int($attribute)? '<p style="color:darkred;font-style: italic;">Vous avez oublié de renseigner votre <b>'.$value.'</b>' :
                      '<p style="color:darkred;font-style: italic;">Un compte existe déjà pour le <b>'.$attribute.'</b> : <b>'.$value.'</b></p>';
                    }
                  }
                  function mapAttribut($attribut):string{
                      //Mapping des noms d'attributs pour faire correspondre avec le formulaire
                      if($attribut == "nomM") return "First name";
                      else if($attribut == "prenomM") return "Last name";
                      else if($attribut == "adresseMail") return "Email";
                      else if($attribut == "adresseMail") return "Email";
                      else return $attribut;
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
    <script src= <?php echo Settings::RACINE."Assets/Js/signup.js"?>></script>
