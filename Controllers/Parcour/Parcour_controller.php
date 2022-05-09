<?php 
// namespace App\Controllers;
use Projet_Web_parcours\Models\Utilisateur;
use Projet_Web_parcours\Models\Parcour;
use Projet_Web_parcours\Models\Position;
use Projet_Web_parcours\Entities\User;
use Projet_Web_parcours\Entities\Course;
use Projet_Web_parcours\Entities\Point;
use Projet_Web_parcours\Entities\Activity;
use Projet_Web_parcours\Assets\enums\request\Fetch;
use Projet_Web_parcours\Assets\enums\game\Type;
use Projet_Web_parcours\Assets\settings\Settings;


//TODO mettre un namespace et appeler la classe par cette intermediaire
//problème avec l'index.
//use Projet_Web_parcours\Controllers\Index_controller;
require('Controllers/Main/Index_controller.php');
class Parcour_controller extends Index_controller{  
     //Appel le formulaire de création d'un parcour
    function displayParcourCreatePage($errors = null){
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
       //On ajoute les activités
       if(empty($point->activity))continue;
       foreach($point->activity as $activity){
         //TODO inserer l'activité dans le type dédié --> 'enigme image'  ou 'enigme...'.
         //TODO Retourner l'id auto généré qui resulte de l'insertion pour le "gameId".
         $idGame = null;
        //On crée l'activité
        $activite_params = array("position"=>$idPosition,
        "typejeu"=>'type::',
        "gameId"=>$idGame,
        ); 
        $position = new Activity($activite_params);
       }
      }
    }
    function getListActivity(){
      
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