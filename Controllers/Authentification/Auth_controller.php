<?php 

use App\Entity\User;
require('Entities/User_entity.php');


 class Auth_controller{
     function displaySignin(){
        require('Views/Authentification/signin_view.php');
     }
     //TODO le display permet de retourner l'utilisateur vers la vue en cas d'erreur avec un nombres d'arguments varizables, ... convertit tous les arguments dans un tableau
     function displaySignup(...$errors){
        if(empty($errors)){
         require('Views/Authentification/signup_view.php');
        }
        else{
         require('Views/Authentification/signup_view.php');
         foreach($errors[0] as $p){
            echo'<p>Vous avez oublié de remplir votre '.$p.'</p>';
         }
        }
     }
     function verify_signup(){
      $Object = new DateTime();  
      $error_array = array();
      $DateAndTime = $Object->format("d-m-Y"); 
      //Faire des vérifications sur 
      $utilisateur = new User($_POST['lastname'], $_POST['firstname'], $_POST['username'], $_POST['password'], $_POST['email'], $Object->format("d-m-Y"), "18-09-1996", "Novice", "Marcheur_du_dimanche");

      //die('====>'.var_dump((array)$utilisateur));
      foreach ((array)$utilisateur as $champ => $value) {
         //echo preg_replace("/user/i", "", explode('\\',$champ)[1]) .'---'. $value .strlen($value);
         //echo preg_replace("/user/i", "", explode('\\',$champ)[2]) .'---'. $value .strlen($value);
         strlen($value) == 0? array_push($error_array, substr(explode('\\',$champ)[2],5)) :  true;
         //�
     }
     empty($error_array)? true: $this->displaySignup($error_array);
      

      // if(empty($utilisateur->getNom()) || empty($utilisateur->getPrenom()) || empty($utilisateur->getAddress(){
      //    require('Views/Authentification/signup_view.php');
      //    echo "Un des champs n'est pas renseigné ! (Pseudo, mot de passe ou email)";
      //    return;
      // }else if(verify_email($_POST['email'])){
      //    require('Views/Authentification/signup_view.php');
      //    echo "Le mot de passe que vous avez saisis";
      // }else if(verify_username($_POST['username'])){
      //    require('Views/Authentification/signup_view.php');
      //    echo "Le mot de passe que vous avez saisis";
      // }
      // else {
      // //On crer un objet et on le persiste
      // }
     }
 }
