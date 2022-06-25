<?php 
// namespace App\Controllers;
use Projet_Web_parcours\Models\Utilisateur;
use Projet_Web_parcours\Models\Parcour;
use Projet_Web_parcours\Models\Position;
use Projet_Web_parcours\Models\Activite;
use Projet_Web_parcours\Models\Note;
use Projet_Web_parcours\Entities\Review;
use Projet_Web_parcours\Entities\Course;
use Projet_Web_parcours\Entities\Point;
use Projet_Web_parcours\Entities\Activity;
use Projet_Web_parcours\Entities\HistoParcour;
use Projet_Web_parcours\Assets\enums\request\Fetch;
use Projet_Web_parcours\Assets\settings\Settings;

require('Controllers/Main/Index_controller.php');

 class Game_controller extends Index_controller {

    //TODO Charger les informations utilisateur et les implenter dans la vue +  faire des fonction de mise à jour des infos du menbres + static?
    // function launchParcourGame($test){
    //     require('Views/Authentification/signin_view.php');
    //     die("Ici on lance le parcour avec l'id : ".$test[0]);
    // }

    //Appel le formulaire d'entrée de hash game.
    function displayHashForm($error = null){
      !$this->is_session_started()? 
      header("Location: ".Settings::RACINE) :
      require('./Views/Game/hash_view.php');
    }

    function displayGame(){
      $gameParam = null;
      if(!$this->is_session_started()) 
      header("Location: ".Settings::RACINE);
      $hashcode = isset($_POST['hashcode'])?$_POST['hashcode']:null;
      $codePa = isset($_POST['codePa'])?$_POST['codePa']:null;
      //Si les deux codes sont nulles on return vers l'acceuil.
      if(!isset($hashcode) && !isset($codePa)) header("Location: ".Settings::RACINE);
      //On vérifie si le parcour n'est pas bloqué et si il existe.
      $dataParams = isset($codePa)?$codePa: $hashcode;
      if(isset($dataParams)){
        //On verifie que la combinaison de paramètre est au bon format
        if (sizeof(explode('_',$dataParams)) != 2) header("Location: ".Settings::RACINE);
        if(explode('_',$dataParams)[0] != "codePa" && explode('_',$dataParams)[0] != "hash") header("Location: ".Settings::RACINE);            
        //On vérifie si le parcour n'est pas bloqué et si il existe.
        $codeP = explode('_',$dataParams)[1];
        $typeP = !isset($codePa)?"hashCode":"codePa";
        $pass = Parcour::existParcour(array($typeP => $codeP), array("activation")); //todo centraliser, nettoyer le code
        $activData = $pass->fetch(Fetch::_ASSOC);
        $datasLength = intval(sizeof($pass->fetchAll()));
        if( intval(sizeof($activData)) === 0 || $activData['activation'] === 0){
          header("Location: ".Settings::RACINE);
        }
      }
      
      //On récupère le step si il y en à un en post ou via la session de jeu.
      if(isset($_SESSION['game'])){
        $step = $_SESSION['game'];
      }elseif(isset($_POST['step'])){
        $step = $_POST['step'];
      }else{
        $step = null;
      }
      
      if(isset($step)){
        $gameParam = isset($hashcode)? $hashcode."_".$step : $codePa."_".$step;
      }else{
        $gameParam = isset($hashcode)? $hashcode : $codePa;
      }
      require('./Views/Game/maingame_view.php');
    }

    //Vérifie si l'utilisateur à déjà une partie en cour
    function verifyParcourStep($code){
      $hash = null;
      $codePa = null;

      //On récupère la nature de la clé et la clé.
      $natureKey = explode('_', $code[0])[0];
      $key = explode('_', $code[0])[1];
      if($natureKey == "hash"){
        $hash = $key;
      }else{
        $codePa = $key;
      }
      
      $user_params = Utilisateur::existUser(array("username" =>$_SESSION['username']), array("codeM"));
      $user =(int)$user_params->fetch(Fetch::_ASSOC)["codeM"];

      if(isset($hash)){
        //D'abord on vérifie que le parcour existe
        $parcour_request = Parcour::existParcour(array("hashCode"=> $hash));
        $parcour_array = $parcour_request->fetch(Fetch::_ASSOC); 
      }else{
        //D'abord on vérifie que le parcour existe
        $parcour_request = Parcour::existParcour(array("codePa"=> $codePa));
        $parcour_array = $parcour_request->fetch(Fetch::_ASSOC); 
      }
      //Le parcour existe alors
      if($parcour_array != false){ 
        $parcour = new Course($parcour_array);
        //On cherche le nombre de position qu'il y a dans le parcour
        $nombrePoints = Position::existPosition(array("parcour"=>$parcour->getCodePa()), array("COUNT(*) as points"));
        $nombrePoints = (int)$nombrePoints->fetch(Fetch::_ASSOC)['points'];
        //On vérifie si le user est déja en game.
        $histo_request = Parcour::existParcourHisto(array("parcour"=>$parcour->getCodePa(),"joueur"=>$user), array('step', 'position', 'time'), array('time'));
        $histo_array= $histo_request->fetchAll();
        //die('===>Nombre points :'.$nombrePoints.'====> step detected'.(int)end($histo_array)->step.'====> position detected'.(int)end($histo_array)->position);
        if($histo_array != false && $nombrePoints != (int)end($histo_array)->step && (int)end($histo_array)->step != 0){
          $histo = new stdClass();
          $step = (int)end($histo_array)->step;
          $time = end($histo_array)->time;
        //On commence à remplir l'objet.
          $histo->nomPa = $parcour->getNomPa();         
          $histo->step = $step;
          $histo->time = $time;         
          //On vas chercher la $step ième position.
          $position_request = Position::existPosition(array("parcour"=>$parcour->getCodePa()), order: array('codePo'));
          $point = $position_request->fetchAll();
          $position = new Point((array)$point[$step - 1]);
          $histo->nomPo = $position->getNomPo(); 
          echo json_encode($histo);
          return;
        }else{
          echo false;
          return;
        }
      }else{
        echo "non exist";
      }
    }

    //On construit le gameObject.
    function buildGameObject($gameParams){ //todo gérer les steps et le fait que on prenne pas toutes les positions.
      $hashcode = null;
      $codePa = null;
      $typeId = explode('_',$gameParams[0])[0];
      $valueId = explode('_',$gameParams[0])[1];
      if($typeId == 'codePa'){
          $codePa = $valueId;
      }else{
          $hashcode = $valueId;
      }
      $step = isset($gameParams[1])?$gameParams[1]:null;
      if(isset($hashcode)){
        //D'abord on vérifie que le parcour existe
        $parcour_request = Parcour::existParcour(array("hashCode"=> $hashcode));
        $parcour_array = $parcour_request->fetch(Fetch::_ASSOC); 
      }else{
        //D'abord on vérifie que le parcour existe
        $parcour_request = Parcour::existParcour(array("codePa"=> $codePa));
        $parcour_array = $parcour_request->fetch(Fetch::_ASSOC); 
      }
      //Le parcour existe alors 
      $GameObject = new stdClass();
      $GameObject->positions = array();  
      //On crée le parcour.
      foreach($parcour_array as $parcourAttribute => $value)
          $GameObject->$parcourAttribute = $value;
      //On vas chercher toutes les positions du parcour.
      $position_request = Position::existPosition(array("parcour"=>$GameObject->codePa), order: array('codePo'));
      $points =  isset($step)?array_slice($position_request->fetchAll(), $step-1):$position_request->fetchAll();
      //while($point = $position_request->fetch(Fetch::_ASSOC)){
      foreach($points as $point){
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
      echo json_encode($GameObject);
  }
  
  //Modifie la session de jeu courante (pour le step), met à jour la BDD sur l'avancement des activités et du parcour en cour.
  //Recois objet
  function incrementStepSession(){
    $game = json_decode($_POST["gameStep"]);
    //On récupère le joueur.
    $utilisateur = Utilisateur::existUser(array('username' => $_SESSION['username']), array('codeM'));
    $codeUser = (int)$utilisateur->fetch(Fetch::_ASSOC)['codeM'];
    //On récupère le datetime
    date_default_timezone_set('Europe/Paris');
    $date = date('Y-m-d H:i:s');
    //On contruit l'array hydrateur histo param.
    $historique_params = array('joueur'=>$codeUser,'parcour'=>(int)$game->parcour,'step'=>(int)$game->step,'position'=>(int)$game->position,'time'=>$date);
    $historique = new HistoParcour($historique_params);
    //On envoie l'historique
    Parcour::persistParcourHisto($historique);
    // die("======> Le step session est =>".(int)$game->step);
    //On incrémante la session de jeu.
     if(isset($_POST['gameStep'])){
      $_SESSION['game'] = (int)$game->step;
     }else{
       die("Pas d'incrémentation du step possible, error");//Ne devrait pas arriver.
     }
  }

  function addNoteToParcours(){
    $stars = json_decode($_POST["stars"]);
    //On récupère le datetime.
      date_default_timezone_set('Europe/Paris');
      $date = date('Y-m-d H:i:s');
      $note_params = array(
        "codePa"=>htmlspecialchars($stars->codePa),
        "codeM"=>htmlspecialchars($_SESSION['userID']),
        "note"=>htmlspecialchars($stars->note),
        "commentaire"=>htmlspecialchars($stars->commentaire),
        "dateN"=> htmlspecialchars($date),
      ); 
      $new_note = new Review($note_params); 
      Note::persistNote($new_note);
      echo "sended";
  }
 }
