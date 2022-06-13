<?php

// namespace Projet_Web_parcours\Controllers;

use Projet_Web_parcours\Entities\User;
use Projet_Web_parcours\Entities\Session;
use Projet_Web_parcours\Models\Utilisateur;
use Projet_Web_parcours\Assets\settings\Settings;
use Projet_Web_parcours\Models\Note;
use Projet_Web_parcours\Models\Parcour;
use Projet_Web_parcours\Models\Position;
use Projet_Web_parcours\Models\Activite;
use Projet_Web_parcours\Models\Utilisateur;

//use Projet_Web_parcours\Controllers\Index_controller;
require('Controllers/Main/Index_controller.php');

 class Dashboard_controller extends Index_controller {

     

     //Appel de l'affichage de graphiques et récuper les données de la base de données.
     function displayDashboard($errors = null){   
      if($this->is_session_started()){
         $correspondance_array = Utilisateur::existUser(array('username' => $_SESSION['username']));
                if($correspondance_array->rowCount() != 0){
                    $utilisateur_params = $correspondance_array->fetch(Fetch::_ASSOC);
                    $utilisateur = new User($utilisateur_params);
               }
               
              require('Views/Dashboard/dashboard_view.php');
      } else{
         header("Location: ".Settings::RACINE) ;
      }
      
     
      
     }
      

   
 }
