<?php

// namespace Projet_Web_parcours\Controllers;

use Projet_Web_parcours\Entities\User;
use Projet_Web_parcours\Entities\Session;
use Projet_Web_parcours\Controllers\Game\Game; //TODO éclaircir pour les vues 
use Projet_Web_parcours\Models\Equipe;
use Projet_Web_parcours\Entities\Team;
use Projet_Web_parcours\Assets\enums\request\Join;
use Projet_Web_parcours\Assets\enums\request\Operator;
use Projet_Web_parcours\Assets\enums\request\Fetch;
use Projet_Web_parcours\Assets\settings\Settings;
use Projet_Web_parcours\Models\Utilisateur;


//use Projet_Web_parcours\Controllers\Index_controller;
require('Controllers/Main/Index_controller.php');

 class Equipe_controller extends Index_controller {

     private $nbMaxOfEquipeMember=5;

     //Appel le formulaire de création d'équipe.
     function displayEquipe($errors = null){   
      if($this->is_session_started()){
         $correspondance_array = Utilisateur::existUser(array('username' => $_SESSION['username']));
                if($correspondance_array->rowCount() != 0){
                    $utilisateur_params = $correspondance_array->fetch(Fetch::_ASSOC);
                    $utilisateur = new User($utilisateur_params);
               }     
         if($utilisateur->getEquipe()!= null){ // s'il est le créateur de l'équipe
            $userData = Utilisateur::existUserAll(); //on liste tous les utilisateur
            $userData =$userData->fetchAll(Fetch::_ASSOC);   
            //crée les entité utilisateur
            $utilisateursToInivite=[];
            $utilisateursInTheTeam=[];
            foreach($userData as $value){
               if($value["equipe"]==NULL){ //si les utilisateurs sont dans aucun équipe
                  array_push($utilisateursToInivite,  new User($value));
               } elseif($value["equipe"]==$utilisateur->getEquipe()){ //si les utilisateurs sont dans l'équipe du créateur
                  if($value["codeM"]!=$utilisateur->getCodeM()){
                     array_push($utilisateursInTheTeam, new User($value));
                  }
                  
               }
               
            }
         } 

        
         //crée l'entité de l'équipe
         require('Views/Equipe/equipe_view.php');
      } else{
         header("Location: ".Settings::RACINE) ;
      }
      
     
      
     }

     

      

     

   //Vérifie si la création de l'équip est conforme
   function verify_signup(){ 
          //Construction de l'array pour l'hydrateur du constructeur de la classe User =>>>
          $user=$_POST['userId'];
         $equipe_params = array("nomE"=>htmlspecialchars($_POST['teamname']),
           "dateCrea"=>date('Y-m-d'),
           "codeCreateur"=>htmlspecialchars($user),
           "emblemE"=>htmlspecialchars($_POST['avatar']),
         ); 
         $equipe = new Team($equipe_params);   
        
         //Vérification des champs vides
         [$flag, $datasEmpty] = $this->emptyFields($equipe);
      
         

         //Vérification du nom d'équipe
          
          if(!preg_match("/((?!.*[!@#\$%\^&\*()--+={}\[\]|\"\\:;'<>,.?\/_₹~`\s]).{3,20})/", $equipe->getNomE())){
            $this->displayEquipe(array("Equipe Name (Format invalid)"));
            return;
         } 
         Equipe::persistEquipe($equipe);
         $equipeID=Equipe::existEquipe($equipe_params);
         $equipeID=$equipeID->fetchAll();
         $equipeID=$equipeID[0]->codeE;
         Utilisateur::updateUser(array('equipe' => $equipeID),array("codeM"=>$user)); 
         //On libère l'objet
         unset($equipe);
         echo "<script>location.href =('".Settings::RACINE."/Equipe/Equipe_controller/displayEquipe') </script>";
      
   }

     

   //Vérification du changement de nom de l'équipe
   function verify_change(){
    
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


      
      
      
      //vérifie que l'équipe n'est pas complete car on peut être que 5 par équipe.
      //on peut qu'être 5 par équipe
      function canAddUser($nombreDeMembredeEquipe){
            if($nombreDeMembredeEquipe<=$this->nbMaxOfEquipeMember){
               return true;
            }
            else{
               return false;
            } 
            
        }


      //fonction pour ajouter l'équipe a l'utilisateur
      //lui envoyé une notification email
      function addUserToEquipe(){
            $equipe=$_POST["idEquipe"];
            $user=$_POST["idUtilisateur"];
         $userData= Utilisateur::existUser(array('codeM' => $user)); //récuper l'utilisateur
         $userData=$userData->fetchAll();
         $userPrenom=$userData[0]->prenomM;
         $mail=$userData[0]->adresseMail;

         $equipeData= Equipe::existEquipe(array('codeE' => $equipe));
         $equipeData=$equipeData->fetchAll();
         $equipeNom=$equipeData[0]->nomE;
         $equipeId=$equipeData[0]->codeE;

         $userNb= Utilisateur::existUser(array('equipe' => $equipeId)); //on récupérer les utilisateur qui sont déja dans l'équipe pour les compter
         $userNb= $userNb->fetchAll();
         $userNb=sizeof($userNb); //on besoin du nombre de membre de l'équipe pour vérifier quel n'est pas complètes
            if($this->canAddUser($userNb)){ //si on peut ajouter un utilisateur les équipe sont limité en 5 utilisateur
            if($userData[0]->equipe==NULL){ //si l'utilisateur n'est pas dans une équipe on l'ajoute a l'équipe
               Utilisateur::updateUser(array('equipe' => $equipe),array("codeM"=>$user)); //on ajoute l'utilisateur dans l'équipe
               if(isset($mail)){
                  $url=Settings::RACINE;
                  $message = "Bonjour ".$userPrenom.",\n vous avez été ajouter a l'équipe $equipeNom : $url .\n Bonne course avec votre équipe. \n L'équipe de fastadventure.";
                  $headers = 'Content-type: text/plain; charset="utf-8"'." ";
                  /*if(mail($mail, 'TeamFastaventure : Vous avez été ajouter a l\'equipe : '.$equipeNom, $message, $headers)){
                     echo "alert";
                  }else{
                     die("Une erreure est survenue ...");
                  } */
               } 
            } else{
               die("Erreur l'utilisateur est déja dans une équipe");
            }
            } else{
               echo "votre équipe est déja complete, les équipe sont limités a ".$this->nbMaxOfEquipeMember." membre, veillez exclure un membre avant d'en rajouter un nouveau";
               die();
            }
           echo "<script>location.href =('".Settings::RACINE."/Equipe/Equipe_controller/displayEquipe')</script>";
        
      }

      //on eleve un utilisateur  d'une équipe 
      //pour cela on met son champ équipe a NULL dans la table membre
      //chaque utilisateur n'apparait qu'a une et une seul équipe on a donc pas besoin de conaitre l'équipe dans la quel il est pour le suprimer.
      function removeUserToEquipe(){
         $userId=$_POST["idDeleteMembre"]; //on récupère l'identitifant de l'utilisateur renvoyé par le view
         Utilisateur::updateUser(array('equipe' => NULL),array('codeM' => $userId));
         echo "<script>location.href =('".Settings::RACINE."/Equipe/Equipe_controller/displayEquipe') </script>";
      }

      //suprimer une équipe et mettre le champ equipe des membres a null
      function deleteEquipe(){
         $equipe=$_POST["idDeleteEquipe"];
         $user_list = Utilisateur::existUser(array('equipe' => $equipe)); //récuper la liste de l'ensemble de l'utilisateur
         $user_list=$user_list->fetchAll();
         foreach($user_list as $value){ //suprimer to le membre de l'équope
            Utilisateur::updateUser(array('equipe' => NULL),array("codeM"=>$value->codeM));
         }
         Equipe::deleteEquipe($where=(array('codeE' => $equipe))); //on suprime l'équipe 
        
         echo "<script>location.href =('".Settings::RACINE."/Equipe/Equipe_controller/displayEquipe')</script>";
       }

      

   
 }
