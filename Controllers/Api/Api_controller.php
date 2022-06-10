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


 class Api_controller {

     //On réagis au get.
     function getUser($arrayParams){
         if(empty($arrayParams)){
            $user_params = Utilisateur::existUserAll();
         }elseif(sizeof($arrayParams) == 1) {
            $user_params = Utilisateur::existUser($where = null, array($arrayParams[0]));
         }else{
            $user_params = Utilisateur::existUser($where = array($arrayParams[0] => $arrayParams[1]));
         }
         //On récupère toutes les données.
         $user_datas = $user_params->fetchAll();
         $value = json_encode($user_datas, JSON_PRETTY_PRINT);
         header("Content-Type: application/json, Content-Length:".strlen($value));
         echo $value."-----------".$_SERVER;
        // die("======> JSON".json_encode($user_datas));
        // require('Views/api_data_view.php');//todo faire page de mise en forme, renvoie le donnée.
     }

    //On réagis au post.
     function postUser($errors = null){
      die("Fonction non disponible, les devs sont en congés");
      require('Views/api_data_view.php');
     }

    //On réagis au put.
     function putUser($errors = null){
      die("Fonction non disponible, les devs sont en congés");
      require('Views/api_data_view.php');
     }
 }
