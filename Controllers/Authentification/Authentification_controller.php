<?php

// namespace Projet_Web_parcours\Controllers;

use Projet_Web_parcours\Entities\User;
use Projet_Web_parcours\Entities\Session;
use Projet_Web_parcours\Controllers\Game\Game; //TODO éclaircir pour les vues 
use Projet_Web_parcours\Models\Utilisateur;
use Projet_Web_parcours\Assets\enums\request\Join;
use Projet_Web_parcours\Assets\enums\request\Operator;
use Projet_Web_parcours\Assets\enums\request\Fetch;

//TODO mettre un namespace et appeler la classe par cette intermediaire
//problème avec l'index.
//use Projet_Web_parcours\Controllers\Index_controller;
require('Controllers/Main/Index_controller.php');



 class Authentification_controller extends Index_controller {

      //Appel le formulaire d'authentification
     function displaySignin($errors = null){
      $this->is_session_started()? 
      $this->rootDirection() : //TODO
      require('Views/Authentification/signin_view.php');
     }

     //Appel le formulaire d'inscription
     function displaySignup($errors = null){
      $this->is_session_started()? 
      $this->rootDirection() : //TODO
      require('Views/Authentification/signup_view.php');
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
