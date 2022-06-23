<?php 
  use Projet_Web_parcours\Assets\settings\Settings;
  if(!isset($utilisateur) || empty($utilisateur)){
    header('Location: '.Settings::RACINE.'');
    return;
  }
?>
<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="row w-100 m-0">
      <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
        <div class="card col-lg-4 mx-auto">
          <div class="card-body px-5 py-5">
            <div class="form-group">
              <a href=<?php echo Settings::RACINE?>>Back</a>
            </div>
            <h3 class="card-title text-left mb-3">Update profile</h3>
            
            <form method="POST" action=<?php echo Settings::RACINE."Settings/Settings_controller/verify_settings/".$utilisateur->getCodeM()?>>
              <div class="form-group">
                <label>First name</label>
                <input type="text" placeholder="First name" name="firstname" value="<?php echo isset($utilisateur) ? $utilisateur->getPrenomM() : ""?>" class="form-control p_input">
              </div>
              <div class="form-group">
                <label>Last name</label>
                <input type="text" placeholder="Last name" name="lastname" value="<?php echo isset($utilisateur) ? $utilisateur->getNomM() : ""?>" class="form-control p_input">
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" placeholder="email@gmail.com" name="email" value="<?php echo isset($utilisateur) ? $utilisateur->getAdresseMail() : ""?>" class="form-control p_input">
              </div>
              <div class="form-group">
                <label>Username </label>
                <input type="text" id ="username" placeholder="Username" name="username" value=<?php echo isset($utilisateur) ? $utilisateur->getUsername() : ""?> minlength="3" maxlength="20" pattern="((?!.*[!@#\$%\^&\*()--+={}\[\]|&quot\\:;'<>,.?/_₹~`\s]).{3,20})" class="form-control p_input">
                <div id="username-error" class="zone-error"></div>
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" placeholder="Password" name="password" minlength="8" maxlength="40" pattern="((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*])(?!.*[()--+={}\[\]|&quot\\:;'<>,.?/_₹~`\s]).{8,40})" class="form-control p_input">
                <div id="password-error" class="zone-error"></div>
              </div>
              <div class="form-group">
                    <label>Confirmation password</label>
                    <input type="password" id="confirmPassword" placeholder="Password" name="confirmPassword" minlength="8" maxlength="40" pattern="((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*])(?!.*[()--+={}\[\]|&quot\\:;'<>,.?/_₹~`\s]).{8,40})" class="form-control p_input">
                   <div id="password-error" class="zone-error"></div>
              </div>
              <div class="form-group">
                <label>Birthday</label>
                <input type="date" id="start" name="dateNaissance"
                value="<?php echo isset($utilisateur) ? $utilisateur->getDateNaissance() : "" ?>"
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
                      <img src= <?php echo Settings::RACINE."Assets/Images/faces/".$utilisateur->getAvatar()?> alt="image" id="avatar-preview" class="rounded-circle"/>
                      
                </div>
                <input type="text" id="form-avatar" value="<?php echo isset($utilisateur) ? $utilisateur->getAvatar() : "" ?>" name="avatar" hidden>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block enter-btn">Update</button>
              </div>
            </form>
            <p class="text-muted mb-1"><button id="delete-user" value="<?php echo $utilisateur->getCodeM()?>" type="button" class="btn btn-outline-danger"> <i class="mdi mdi-delete-forever"></i>Supprimer votre compte</button></p>
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
<script src= <?php echo Settings::RACINE."Assets/Js/settings.js"?>></script>