<?php

// namespace Projet_Web_parcours\Controllers;

use Projet_Web_parcours\Entities\User;
use Projet_Web_parcours\Entities\Session;
use Projet_Web_parcours\Controllers\Game\Game; //TODO éclaircir pour les vues 
use Projet_Web_parcours\Models\Utilisateur;
use Projet_Web_parcours\Assets\enums\request\Join;
use Projet_Web_parcours\Assets\enums\request\Operator;
use Projet_Web_parcours\Assets\enums\request\Fetch;
use Projet_Web_parcours\Assets\settings\Settings;

//TODO mettre un namespace et appeler la classe par cette intermediaire
//problème avec l'index.
//use Projet_Web_parcours\Controllers\Index_controller;
require('Controllers/Main/Index_controller.php');



 class Authentification_controller extends Index_controller {

     //Appel le formulaire d'authentification.
     function displaySignin($errors = null){
      $this->is_session_started()? 
      header("Location: /") :
      require('Views/Authentification/signin_view.php');
     }

     //Appel le formulaire d'inscription.
     function displaySignup($errors = null){
      $this->is_session_started()? 
      header("Location: /") :
      require('Views/Authentification/signup_view.php');
     }

     //Appel le formulaire de récupération du mot de passe.
     function displayForgot($errors = null){
      require('Views/Authentification/forgot_view.php');
     }

     //Appel le formulaire de changement de mot de passe.
     function displayPassChange($token, $errors = null){
      //   die("======> Errors".var_dump($errors));
      if(isset($errors)){
         $email = $errors->email;
         $errors = $errors->msg;
         require('Views/Authentification/passChange_view.php');
         return;

      }
      //Si on reçois un token de récupération, on vérifie si il existe dans la base.
      if(isset($token[0]) && $token[0] != ''){
         $token = $token[0];
         $utilisateur_stmt = Utilisateur::existUser(array('token' => $token), array('adresseMail'));
         $email = $utilisateur_stmt->fetch(Fetch::_ASSOC)['adresseMail'];
       
         if($email){
            require('Views/Authentification/passChange_view.php');
         }
      }
     }

   //Vérifie si l'inscription de l'utilidateur est conforme
   function verify_signup(){ 
          //Construction de l'array pour l'hydrateur du constructeur de la classe User =>>>
         $utilisateur_params = array("nomM"=>htmlspecialchars($_POST['lastname']),
           "prenomM"=>htmlspecialchars( $_POST['firstname']),
           "username"=>htmlspecialchars($_POST['username']),
           "password"=>htmlspecialchars($this->removeAccent($_POST['password'])),
           "adresseMail"=>htmlspecialchars($_POST['email']),
           "dateNaissance"=>htmlspecialchars($_POST['dateNaissance']),
           "dateInscription"=>htmlspecialchars(date('Y-m-d')),
           "avatar"=>htmlspecialchars($_POST['avatar']),
         ); 
         $utilisateur = new User($utilisateur_params);   

         //Vérification des champs vides
         [$flag, $datasEmpty] = $this->emptyFields($utilisateur);
         if($flag){
            //Equipe est null quand on crée un utilisateur
            in_array('equipe', $datasEmpty)? array_splice($datasEmpty, array_search('equipe', $datasEmpty),1) : true;
            if(!empty($datasEmpty)){
               $this->displaySignup(errors: $datasEmpty); 
               return;
            }
         }

         //Vérification de l'username
          //TODO il manque l'interdiction de mettre des "\".
          if(!preg_match("/((?!.*[!@#\$%\^&\*()--+={}\[\]|\"\\:;'<>,.?\/_₹~`\s]).{3,20})/", $utilisateur->getUsername())){
            $this->displaySignup(array("Username (Format invalid)"));
            return;
         }

         //Vérification du mot de passe
          //TODO il manque l'interdiction de mettre des "\".Message erreur qui indique que mauvais regex.
         if(!preg_match("/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*])(?!.*[()--+={}\[\]|\"\\:;'<>,.?\/_₹~`\s]).{8,40})/", $utilisateur->getPassword())){
            $this->displaySignup(array("Password (Format invalid)"));
            return;
         }
         //On hash le mot de pass
         $utilisateur->setPassword(password_hash($utilisateur->getPassword(),PASSWORD_DEFAULT));
         //TODO Regex pour l'id de l@Mail
         //Vérification conformité de l'@ mail
         if(!filter_var($utilisateur->getAdresseMail(), FILTER_VALIDATE_EMAIL)){
            $this->displaySignup(array("Adresse email (Format invalid)"));
            return;
         }

         //Vérification redondance de l'@ mail ou du username dans la BDD est ce que l'email ou le username, ou les deux, sont déjà utilisés.
         $existing_fields = Utilisateur::redundancyUser(array("COUNT(*) AS utilisateur"), $utilisateur->reduceUserArray(2,2));
         if($existing_fields != false){
            $this->displaySignup($existing_fields);
         }else{
            Utilisateur::persistUser($utilisateur);           
            $this->displaySignin();
         }
         //On libère l'objet
         unset($utilisateur);
   }

   //Vérification de l'authenticité de l'inscription
   function verify_signin(){
      //Si un utilisateur tape l'URl
      if(!isset($_POST['usernameoremail']) || !isset($_POST['password'])){
         $this->rootDirection();
         return;
      } 
         //Construction de l'array pour l'hydrateur du constructeur de la classe Session.
         $session_params = array(
          "identifiant"=>htmlspecialchars($_POST['usernameoremail']),
          "password"=>htmlspecialchars($this->removeAccent($_POST['password'])),
         ); 
         $session = new Session($session_params);

         //Vérification des champs vides
         [$flag, $datas] = $this->emptyFields($session);
         if($flag){
            $this->displaySignin($datas);
            return;
         }
         //On vérifie si l'utilisateur existe dans la base.
         $correspondance_array = Utilisateur::existUser($session->reduceSessionArray(0,1));
         if($correspondance_array->rowCount() != 0){
            $utilisateur_params = $correspondance_array->fetch(Fetch::_ASSOC);
            //array_shift($utilisateur_params);
            $utilisateur = new User($utilisateur_params); 
            if(password_verify($session->getPassword(), $utilisateur->getPassword())){
               //On crée la session utilisateur
               $_SESSION['username'] = $utilisateur->getUsername();
               //On renvoie l'utilisateur sur l'acceuil
               //$this->rootDirection(utilisateur: $utilisateur);
               header("Location: /");
            }else{
               $this->displaySignin(array( "Password" => $session->getIdentifiant()));
            }
         }else{
            $this->displaySignin(array( "Identifiant" => $session->getIdentifiant()));
         }
         //TODO faire des Constructeurs qui acceptent les fecthObjet, sans hydrateurs, pour autres entités.
         //die( "Le resultat final est =>".var_dump($correspondance_array->fetchObject('Projet_Web_parcours\Entities\User', )));  

         unset($session);
   }

   //Vérification du reset du mot de passe, envoie du mail de changement.
   function verify_forgot(){ //todo vérifier que c'est bien une adresse mail -> js pour les erreurs en temps réel ?.
      if(isset($_POST['email']) && $_POST['email'] != ''){
         $mail = $_POST['email'];
         $utilisateur = null;
         //On vérifie que l'email est un bon email.
         $correspondance_array = Utilisateur::existUser(array('adresseMail' => $mail));
         if($correspondance_array->rowCount() != 0){
            $utilisateur_params = $correspondance_array->fetch(Fetch::_ASSOC);
            $utilisateur = new User($utilisateur_params);
         }else{ //Mauvais email.
            $this->displayForgot("L'email entré ne correspond à aucun utilisateur.");
         }
         //On crée le token de récupération.
         $token = uniqid();
         // $url = Settings::RACINE."Authentification/Authentification_controller/displayPassChange?token=$token";
         $url = Settings::RACINE."Authentification/Authentification_controller/displayPassChange/$token";
         $message = "Bonjour".$utilisateur->getPrenomM().",\n Veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe : $url .\n Bonne continuation. \n L'équipe de fastadventure.";
         $headers = 'Content-type: text/plain; charset="utf-8"'." ";
         if(mail($mail, 'TeamFastaventure : Mot de passe oublie', $message, $headers)){
            Utilisateur::updateUser(array('token' =>$token), array('adresseMail' => $mail));
            echo 'Mail envoyé. Veuillez consulter vos mails pour récupérer votre mot de passe. ';//todo mettre un set time pour afficher l'écho.
            header("Location: /");
         }else{
            die("Une erreure est survenue ...");
         }
      }else{
         $this->displayForgot("Veuillez saisir, une adresse mail");
      }
   }

   //Vérification du changement de mot de passe.
   function verify_change(){
      //Si on reçois bine l'email.
      if( isset($_POST['email'])){
         //On vérifie si les mots de passe existe.
         if(!isset($_POST['passwordConfirm']) || !isset($_POST['password'])){
            //On crée l'ojet d'erreur.
            $erros_obj = new stdClass();
            $erros_obj->msg = "Vous devez saisir un mot de passe.";
            $erros_obj->email =  $_POST['email'];
            $this->displayPassChange(null, errors: $erros_obj);
            // unset($erros_obj);
            return;
         } 
         //On vérifie si ils ne sont pas vide.
         if($_POST['passwordConfirm'] == '' || $_POST['password'] == ''){
            //On crée l'ojet d'erreur.
            $erros_obj = new stdClass();
            $erros_obj->msg = "Vous devez saisir un mot de passe.";
            $erros_obj->email =  $_POST['email'];
            $this->displayPassChange(null, errors: $erros_obj);
            // unset($erros_obj);
            return;
            
         } 

         //On récupère les éléments
         $password = $_POST['password'];
         $passwordConfirm = $_POST['passwordConfirm'];
         $email = htmlspecialchars($this->removeAccent($_POST['email']));
         //On vérifie si les deux mots de passe 
          if($password == $passwordConfirm){
            $password = password_hash(htmlspecialchars($this->removeAccent($password)),PASSWORD_DEFAULT);
            //On met à jour l'utilisateur par rapport à son email.
            Utilisateur::updateUser(array('password' => $password,'token' => NULL), array('adresseMail' => $email));
            echo 'Mot de passe modifié avec succès';
            header("Location: /Authentification/Authentification_controller/displaySignin");
          }else{
             //On crée l'ojet d'erreur.
             $erros_obj = new stdClass();
             $erros_obj->msg = "Confirmation échouée. Les mots de passe ne sont pas identique";
             $erros_obj->email =  $email;
            $this->displayPassChange(null, errors: $erros_obj);
            unset($erros_obj);
          }
      }else {
         die("Error -> Il n'y à pas d'email utilisateur");
      }
   }

      public function convertObj($obj): string{
         die(explode('\\',get_class($obj))[2]);
      }

      //Vérifie si il y a des champs vides dans l'objet passé en paramètre
      public function emptyFields($obj){
         
         $empty_fields = array();
         //On parcour l'objet que l'on transforme en array pour savoir si il y a des champs vides
         foreach ($obj->to_Array() as $champ => $value) {
            empty($value)? array_push($empty_fields, $champ) : true;
         }
         //Si il y a des champs vides, renvoi true du formulaire avec des notification d'erreur
        return !empty($empty_fields)? [true, $empty_fields]: [false, $empty_fields];
      }

      //Enlever les accents de la chaine passée en parametre.
      public function removeAccent($value){
         $str = htmlentities($value, ENT_NOQUOTES, 'utf-8');
         $str = preg_replace('#&([A-za-z])(?:uml|circ|tilde|acute|grave|cedil|ring);#', '\1', $str);
         $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
         $str = preg_replace('#&[^;]+;#', '', $str);
         return $str;
         //die("Le nouveau mot est =>".$str);
      }
 }
