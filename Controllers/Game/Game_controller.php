<?php 
// namespace App\Controllers;
use Projet_Web_parcours\Models\Utilisateur;
use Projet_Web_parcours\Models\Parcour;
use Projet_Web_parcours\Models\Position;
use Projet_Web_parcours\Models\Activite;
use Projet_Web_parcours\Entities\User;
use Projet_Web_parcours\Entities\Course;
use Projet_Web_parcours\Entities\Point;
use Projet_Web_parcours\Entities\Activity;
use Projet_Web_parcours\Entities\Jeu_texte;
use Projet_Web_parcours\Assets\enums\request\Fetch;
use Projet_Web_parcours\Assets\enums\game\Type;
use Projet_Web_parcours\Assets\settings\Settings;

require('Controllers/Main/Index_controller.php');

 class Game_controller extends Index_controller {

    //TODO Charger les informations utilisateur et les implenter dans la vue +  faire des fonction de mise à jour des infos du menbres + static?
    function launchParcourGame($test){
        require('Views/Authentification/signin_view.php');
        die("Ici on lance le parcour avec l'id : ".$test[0]);
    }

    //Appel le formulaire d'entrée de hash game.
    function displayHashForm($error = null){
      !$this->is_session_started()? 
      header("Location: /") :
      require('./Views/Game/hash_view.php');
     }
    //Vérifie si l'inscription de l'utilidateur est conforme
   function verify_hascode(){
    $GameObject = null;
    $hascode = $_POST['hascode'];
    if(!isset($hascode) || empty($hascode)){
        $this->displayHashForm(error:"Vous devez entrer un hascode");
        return;
    }
    //On vas chercher toutes les informations pour la game dans la base, et on fait un objet avec pour tout condenser.

    //D'abord on vérifie que le parcour existe
    $parcour_request = Parcour::existParcour(array("hashCode"=> $hascode));
    $parcour_array = $parcour_request->fetch(Fetch::_ASSOC); 
    //Le parcour existe alors
    if($parcour_array != false){   
        $GameObject = new stdClass();
        $GameObject->positions = array();  
        //On crée le parcour.
        foreach($parcour_array as $parcourAttribute => $value)
            $GameObject->$parcourAttribute = $value;
        //On vas chercher toutes les positions du parcour.
        $position_request = Position::existPosition(array("parcour"=>$GameObject->codePa));
       while($point = $position_request->fetch(Fetch::_ASSOC)){
         //On crée la position.
         $position = new stdClass();
         $coordonnees = array();
         $position->activites = array();
         foreach($point as $pointAttribute => $value){             
           if($pointAttribute == "latitude" || $pointAttribute == "longitude"){
             array_push($coordonnees, $value);
             continue;
           }
           $position->$pointAttribute = $value;
         }
         //On ajoute les coordonnées.
         $position->coord = $coordonnees;
         
         //On vas chercher les activités de la positions.        
         $activites_request = Activite::existActivity(array('position' => $position->codePo));
         while($activity = $activites_request->fetch(Fetch::_ASSOC)){
           $game = new stdClass();
           $activite = new Activity($activity);
           //On vas chercher le vrai jeu
           $game_request = Activite::existActiviteGame($activite->getActiviteType(), array('id' => $activite->getActivite()));
           $game_array = $game_request->fetch(Fetch::_ASSOC);
           //On ajoute le nom du jeu dans l'activité dans la position et l'id de l'activité de rescencement.     
           $game->nomAc = $activite->getActiviteType();
           $game->codeAct = $activite->getCodeAct();
           foreach($game_array as $gameAttribute => $value)
             $game->$gameAttribute =  $value;
           array_push($position->activites, $game);
         }
         //On ajoute la position dans le parcour.
         array_push($GameObject->positions, $position);
       }
       die("Le parcour que l'on vas lancer est ==>".json_encode($GameObject));
       //echo json_encode($GameObject);
      // unset($GameObject);
    }else{
        $this->displayHashForm(error:"Aucun parcour ne correspond à votre hascode, veuillez réessayer");
        return; 
    }

   }
 }
