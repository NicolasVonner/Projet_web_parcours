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


//TODO mettre un namespace et appeler la classe par cette intermediaire
//problème avec l'index..

//use Projet_Web_parcours\Controllers\Index_controller;
require('Controllers/Main/Index_controller.php');
class Parcour_controller extends Index_controller{  
     //Appel le formulaire de création d'un parcour
    function displayParcourCreatePage($errors = null){ //TODO c'est ici qu'on vas rentrer pour modifier les parcours.
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
      require('Views/Parcour/createParcours_view.php');
    }

    //Crée un parcour
    function createParcour(){
      $course = json_decode($_POST["parcours"]);
      //On récupère le créateur
      $utilisateur = Utilisateur::existUser(array('username' => $_SESSION['username']), array('codeM'));
      $codeUser = (int)$utilisateur->fetch(Fetch::_ASSOC)['codeM'];
      //On crée le parcour
      $course_params = array("createur"=>$codeUser,
        "nomPa"=>htmlspecialchars($course->nomPa),
        "descriptionPa"=>substr(htmlspecialchars($course->descriptionPa), 0, 64000),
        "dateCreation"=>htmlspecialchars(date('Y-m-d')),
        "dateDerniereModif"=>htmlspecialchars(date('Y-m-d')),
        "hashCode"=>$this->generatehash(),
      ); 
      $parcour = new Course($course_params);  

      //On récupère l'id du parcour inséré pour l'insetion des positions. 
      $idParcour = Parcour::persistParcour($parcour);
      $idParcour = (int)$idParcour->fetch(Fetch::_ASSOC)["LAST_INSERT_ID()"];
      foreach($course->positions as $point){
        //On crée la position
        $position_params = array("parcour"=>$idParcour,
        "nomPo"=>htmlspecialchars($point->nomPo),
        "pays"=>htmlspecialchars($point->pays),
        "latitude"=>(float)$point->coord[0],
        "longitude"=>(float)$point->coord[1],
       ); 
       $position = new Point($position_params);
       //On récupère l'id de la position insérée pour l'insetion des activités.  
       $idPosition = Position::persistPosition($position);
       $idPosition = (int)$idPosition->fetch(Fetch::_ASSOC)["LAST_INSERT_ID()"];
       //TODO faire en sorte d'ajouter les activités correctement sur le JS.
       //On ajoute les activités.
       if(empty($point->activites))continue;
       foreach($point->activites as $activity){
          $activ_params = (array)$activity;
          //On récupèrte le nom du jeu.
          $typeActiv = array_shift($activ_params);
          //On crée l'objet.
          $typeActivObj = 'Projet_Web_parcours\Entities\\'.ucfirst($typeActiv);
          $activ = new $typeActivObj($activ_params);
          //On insère l'activ dans sa table respective et on récupère l'id.
          $idactiv = Activite::persistActiviteGame($typeActiv, $activ);
          $idactiv = (int)$idactiv->fetch(Fetch::_ASSOC)["LAST_INSERT_ID()"];
          //On créee le tableau pour l'hydrateur de l'activité rescencement.
          $activite_params = array("position"=>$idPosition,
          "activiteType"=>$typeActiv,
          "activite"=>$idactiv,
          );          
          $activite = new Activity($activite_params);
          //On insère l'activité.
          Activite::persistActivite($activite);
       }
      }
    }
    function buildListActivity(){       
      $activityMap = array();
      $paramList = [];

      $activType = Activite::existActivityType(where : null, what : array('nomAc'));
      while ($type = $activType->fetch(Fetch::_ASSOC))
      {
          $games = new stdClass();
          //On récupère les noms des activités existantes.
          $activityNameList = $type["nomAc"];
          //On ajoute le nom de l'activité.
          $games->nomAc = $type["nomAc"];

          //On récupère les attributs des tables des types d'activité existantes.
          $activityParams = Activite::getActivityGameParams($activityNameList);
          while ($params = $activityParams->fetch(Fetch::_ASSOC))
          {
            $params["Field"] === "id"? false : array_push($paramList,$params["Field"]);
          } 
          //On ajoute les parametres.
          $games->attibuts = $paramList;
          //On ajoute l'objet dans le tableau de type de jeux.
          array_push($activityMap, $games); 
           //On vide les variables à chaque fin d'itération.
          $paramList = []; 
          unset($games);  
      }
      echo empty($activityMap)? "There are no activity" : json_encode($activityMap);
    }
    
    //TODO verifier qu'on à bien 2 possibilités avec 1 bit vue qu'il y a convertion. -> Des milliers de parcours pourraient avoir un code trop important pour rien.
    //Retour un hascode unique pour un parcour
    function generatehash(){
      $flag = false;
      $hash = null;
      //Récupère le nombre de parcours en BDD.
      $parcour = Parcour::existParcour(null, array("COUNT(*) as nombreParcour"));
      $nombreParcours = (int)$parcour->fetch(Fetch::_ASSOC)['nombreParcour'];
      //La longeur de la suite de bites générés en fonction du nombre de parcour en bdd -> 1 bit = 2 possibilités.
      if($nombreParcours == 0 || $nombreParcours == 1){
        $hashlength = 1;
      }else{
        $hashlength = log($nombreParcours, 2) % 2 == 0? (int)log($nombreParcours, 2) : (int)log($nombreParcours, 2) + 1;
      }
      
      //On génère un hash pour le parcour jusqu'à ce qu'il soit unique.
      do{
        $bytes = random_bytes($hashlength);
        $hash = bin2hex($bytes);
        $hashVerify = Parcour::existParcour(array('hashCode' => $hash), array("COUNT(*) as unicityHash"));
        $flag = (int)$hashVerify->fetch(Fetch::_ASSOC)['unicityHash'] == 0 ? true : false;
      }while(!$flag);
      return $hash;
    }
}
?>