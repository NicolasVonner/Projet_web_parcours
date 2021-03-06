<?php
// namespace App\Controllers;
use Projet_Web_parcours\Models\Utilisateur;
use Projet_Web_parcours\Entities\User;
use Projet_Web_parcours\Assets\enums\request\Fetch;
use Projet_Web_parcours\Assets\settings\Settings;

require('Controllers/Main/Index_controller.php');

class Settings_controller extends Index_controller { 

    function displaySettings($errors = null) {
      if(!$this->is_session_started()){
        header('Location: '.Settings::RACINE.'');
        return;
      }else{
        $correspondance_array = Utilisateur::existUser(array('username' => $_SESSION['username']));
        if($correspondance_array->rowCount() != 0){
            $utilisateur_params = $correspondance_array->fetch(Fetch::_ASSOC);
            $utilisateur = new User($utilisateur_params);
        }      
      }
      require('Views/Settings/settings_view.php');
    }

    function verify_settings($code) {
      //Si on a pas d'id user on sort.
      if (sizeof($code) == 0 || !isset($code)) {
        return;
      }
      //Construction de l'array pour l'hydrateur du constructeur de la classe User =>>>
      $utilisateur_params = array(
        "codeM"=>htmlspecialchars($code[0]),
        "nomM"=>htmlspecialchars($_POST['lastname']),
        "prenomM"=>htmlspecialchars( $_POST['firstname']),
        "username"=>htmlspecialchars($_POST['username']),
        "password"=>htmlspecialchars($this->removeAccent($_POST['password'])),
        "adresseMail"=>htmlspecialchars($_POST['email']),
        "dateNaissance"=>htmlspecialchars($_POST['dateNaissance']),
        "dateInscription"=>htmlspecialchars(date('Y-m-d')),
        "avatar"=>htmlspecialchars($_POST['avatar']),
      ); 
      $utilisateur = new User($utilisateur_params); 
      
      //On traite le mot de passe en amont.
      if($utilisateur->getPassword() == null){
        $user_param = Utilisateur::existUser(array('codeM' =>$utilisateur->getCodeM()), array('password'));
        $pass = $user_param->fetch(fetch::_ASSOC)["password"];
        $utilisateur->setPassword($pass); 
      }else{
        //V??rification du mot de passe
        //TODO il manque l'interdiction de mettre des "\".Message erreur qui indique que mauvais regex.
        if(!preg_match("/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*])(?!.*[()--+={}\[\]|\"\\:;'<>,.?\/_???~`\s]).{8,40})/", $utilisateur->getPassword())){
          $this->displaySettings(array("Password (Format invalid)"));
           return;
        }
         //On v??rifie si les mots de passe sont identiques
         if($_POST['confirmPassword'] != $utilisateur->getPassword()){
            $this->displaySettings(array("Les mots de passes ne correspondent pas"));
            return;
         }
          $pass = password_hash(htmlspecialchars($this->removeAccent($utilisateur->getPassword())),PASSWORD_DEFAULT);
          $utilisateur->setPassword($pass); 
      }
      //V??rification des champs vides
      [$flag, $datasEmpty] = $this->emptyFields($utilisateur);
      if($flag){
        //Equipe est null quand on cr??e un utilisateur
        in_array('equipe', $datasEmpty)? array_splice($datasEmpty, array_search('equipe', $datasEmpty),1) : true;
        if(!empty($datasEmpty)){
            $this->displaySettings(errors: $datasEmpty); 
            return;
        }
      }

      //V??rification de l'username
      //TODO il manque l'interdiction de mettre des "\".
      if(!preg_match("/((?!.*[!@#\$%\^&\*()--+={}\[\]|\"\\:;'<>,.?\/_???~`\s]).{3,20})/", $utilisateur->getUsername())){
        $this->displaySettings(array("Username (Format invalid)"));
        return;
      }
      // die("USERNAME ===>".$utilisateur->getUsername());
      //On met ?? jour le username
      $_SESSION['username'] = $utilisateur->getUsername();

      //TODO Regex pour l'id de l@Mail
      //V??rification conformit?? de l'@ mail
      if(!filter_var($utilisateur->getAdresseMail(), FILTER_VALIDATE_EMAIL)){
        $this->displaySettings(array("Adresse email (Format invalid)"));
        return;
      }

      //On met ?? jour le user.
      Utilisateur::updateUser($utilisateur->to_Array(), array('codeM' => $utilisateur->getCodeM()));
      
      //On renvoie l'utilisateur sur l'acceuil
      //$this->rootDirection(utilisateur: $utilisateur);
      header("Location: ".Settings::RACINE."Settings/Settings_controller/displaySettings");
    }

    //V??rifie si il y a des champs vides dans l'objet pass?? en param??tre
    public function emptyFields($obj){
         
      $empty_fields = array();
      //On parcour l'objet que l'on transforme en array pour savoir si il y a des champs vides
      foreach ($obj->to_Array() as $champ => $value) {
         empty($value)? array_push($empty_fields, $champ) : true;
      }
      //Si il y a des champs vides, renvoi true du formulaire avec des notification d'erreur
     return !empty($empty_fields)? [true, $empty_fields]: [false, $empty_fields];
   }

    //Enlever les accents de la chaine pass??e en parametre.
    public function removeAccent($value){
      $str = htmlentities($value, ENT_NOQUOTES, 'utf-8');
      $str = preg_replace('#&([A-za-z])(?:uml|circ|tilde|acute|grave|cedil|ring);#', '\1', $str);
      $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
      $str = preg_replace('#&[^;]+;#', '', $str);
      return $str;
      //die("Le nouveau mot est =>".$str);
   }

   //l'utilisateur peut suprimer sont propre compte 
   //afin qu'on concereve pas ces donn??es.
   public function deleteOurOwnAcount(){
   
    $idButton=$_POST["idDeleteUser"]; //id qui est dans le boutton
    $correspondance_array = Utilisateur::existUser(array('username' => $_SESSION['username']));
    if($correspondance_array->rowCount() != 0){
        $utilisateur_params = $correspondance_array->fetch(Fetch::_ASSOC);
        $utilisateur = new User($utilisateur_params);
   }     
    if($idButton==$utilisateur->getCodeM()){ //si c'est bien sont propre compte qu'on chercher a suprimer
        Utilisateur::deleteUser(array('codeM' => $utilisateur->getCodeM()));
        //TODO
        //Parcour::deleteParcour(array("createur"=>$idparcour));
        //il faut suprimer les parcours et les ??quipe s'il en est le cr??ateurs


        // Note::deleteNote(array("codeM"=>$utilisateur->getCodeM()));//on suprime les note que l'utilisateur a ajouter sur les parcours des autres
        //suprimer les parcours cr??e par l'utilisateur
        if(true){ //s'il est le cr??ateur d'une ??quipe. on suprimer l'??quipe en enl??vant tous c'est membre
          //Equipe::deleteEquipe($where=(array('codeE' => $equipe)));
        }
        $_SESSION['username'] = null;
        session_destroy(); 
        header("Location: ".Settings::RACINE);
    } else{
      echo "erreur dans l'identitifiant de l'utilisateur qu'il cherche a suprimer";
    }

   }
}