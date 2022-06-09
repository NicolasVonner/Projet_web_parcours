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
use Projet_Web_parcours\Entities\HistoParcour;
use Projet_Web_parcours\Assets\enums\request\Fetch;
use Projet_Web_parcours\Assets\enums\game\Type;
use Projet_Web_parcours\Assets\settings\Settings;


//TODO mettre un namespace et appeler la classe par cette intermediaire
//problème avec l'index..

//use Projet_Web_parcours\Controllers\Index_controller;
require('Controllers/Main/Index_controller.php');
class Classement_controller extends Index_controller{  
     //Appel le formulaire de création d'un parcour
    function displayParcourCreatePage(){ //TODO c'est ici qu'on vas rentrer pour modifier les parcours.
      if(!$this->is_session_started()){
        header('Location: '.Settings::RACINE.'');
        return;
      }else{
        $correspondance_array = Utilisateur::existUser(array('username' => $_SESSION['username']));
        if($correspondance_array->rowCount() != 0){
            $utilisateur_params = $correspondance_array->fetch(Fetch::_ASSOC);
            $utilisateur = new User($utilisateur_params); 
        }      
        //On vérifie si c'est une modification.
        $editId = isset($_POST['idParcour'])? $_POST['idParcour']:null;
      }
      require('Views/Parcour/createParcours_view.php');
    }

    function displayRankingPage(){
      // die("On souhaite récupérer et afficher le classement des users pour ce parcour");
      $rankId = isset($_POST['idParcour'])? $_POST['idParcour']:null;
      //Si l'id est null, on renvoie l'utilisateur sur l'acceuil
      if(!isset($rankId)) header('Location: '.Settings::RACINE);
      $position_array = Position::existPosition(array("parcour" =>$rankId), array("COUNT(*) AS positions"));
      $position_number = $position_array->fetch(Fetch::_ASSOC)['positions'];
      // die("On a".$position_number."positions pour ce parcour");
      //On récupère tout les joueurs
      $player_request = Parcour::existParcourHisto(null,array("DISTINCT joueur") );
      $players_array =  $player_request->fetchAll();

      //On remplis le tableau des scores
      $nombre = $position_number;
      $currentStepSearch = 1;
      $departureTime = 0;
      $endTime = 0;
      echo'$nombre 
            '.$nombre ;
      foreach($players_array as $player){
        $joueur = $player->joueur;
        //On récupère les historique parcour du joueur.
        $histo_request = Parcour::existParcourHisto(array("parcour"=>$rankId),array("step", "time"));
        while($histo = $histo_request->fetch(Fetch::_ASSOC)){
          // echo"Les parcours pour ce joueur sont =>".var_dump($histo);
          //On vérifie si on à récupéré toutes les positions en début de boucle.
          if($nombre == 0){
            $perf = new stdClass();
            $date1=date_create($endTime);
            $date2=date_create($departureTime);
            $perf->time = date_diff($date1, $date2); //todo date diff.
            // echo"Le joueur à mis : ".$perf->time."  ======> La date de début est ".var_dump($departureTime)." ===> La date de fin est".var_dump($endTime);
            die("Le joueur à mis : ======> La date de début est ".var_dump($departureTime)." ===> La date de fin est".var_dump($endTime));
            echo'Le nombre est à : '.$nombre;
            $departureTime = 0;
            $nombre = $position_number;
            $currentStepSearch = 1;
          }
          $step = intval($histo["step"]);
          //Si c'est un début de recherche.
          echo'Nombre => '.$nombre.' ===> Posiiton number'.$position_number;
          if($nombre == $position_number){
            echo'On est au debut
            ';
            //Si c'est un milieu de parcour on passe au suivant.
            if($step != 1){
              echo'Step différent de 1';
              continue;
            }else{
              echo'Step égal à 1';
              $departureTime = $histo["time"];
              $nombre--;
              $currentStepSearch ++;
              echo'Nombre => '.$nombre. 'currentStepdesire ===> '.$currentStepSearch.'==> step'.$step;
              //todo convertir le diff time en timestamp ou quoi pour pouvoir comparer numériquement. -> jouer avec la valeur.
              //todo ajouter objet dans tableau.
            }
          }else{
            if($step != $currentStepSearch){
              $departureTime = 0;
              $nombre = $position_number;
              $currentStepSearch = 1;
            }else{
              $nombre --;
              $currentStepSearch ++;
              $endTime = $histo["time"];
            }
          }
        }
        //   // die("Les parcours pour ce joueur sont =>".var_dump($histo_array));
      
        //   $time = $player->time;
        //  die("Le premier historique est =>".var_dump($time));
       
      }


      //On vas chercher les user les plus performants
      //Liste de user suite à un select.
      //require(Classement_view);
    }

    //Renvoie l'objet à modifier à l'ajax
    function createObjetEdit($elementPa){  
          $idParcour = $elementPa[0];
           $course = new stdClass();
           //On construit toutes les infos concernant le parcour, object pour js.
           //On vas chercher les infos du parcour.
           $parcour_request = Parcour::existParcour(array('codePa' => $idParcour));
           $parcour_array =  $parcour_request->fetch(Fetch::_ASSOC);
           //On crée le parcour.
           $parcour = new stdClass();
           foreach($parcour_array as $parcourAttribute => $value)
               $parcour->$parcourAttribute = $value;
           //On implemente parcour dans l'objet à renvoyer au js.
           $course = $parcour;
           //On vas chercher les positions du parcour.
           $course->positions = array();
           $position_request = Position::existPosition(array('parcour' => $course->codePa), order: array('codePo'));

          while($point = $position_request->fetch(Fetch::_ASSOC)){
             //On crée la position.
            $position = new stdClass();
            $coordonnees = array();
            foreach($point as $pointAttribute => $value){             
              if($pointAttribute == "latitude" || $pointAttribute == "longitude"){
                array_push($coordonnees, $value);
                continue;
              }
              $position->$pointAttribute = $value;
            }
            //On ajoute les coordonées.
            $position->coord = $coordonnees;
            
            //On vas chercher les activités de la positions.
            $position->activites = array();
            $activites_request = Activite::existActivity(array('position' => $position->codePo));
            while($activity = $activites_request->fetch(Fetch::_ASSOC)){
              $activite = new Activity($activity);
              //On vas chercher le vrai jeu
              $game_request = Activite::existActiviteGame($activite->getActiviteType(), array('id' => $activite->getActivite()));
              $game_array = $game_request->fetch(Fetch::_ASSOC);
              //On ajoute le jeu dans l'activité dans la position.
              $game = new stdClass();
              $game->nomAc = $activite->getActiviteType();
              foreach($game_array as $gameAttribute => $value)
                $game->$gameAttribute =  $value;
              array_push($position->activites, $game);
            }
            //On ajoute la position dans le parcour.
            array_push($course->positions, $position);
          }
          //die("L'objet que l'on vas envoyer au js est ==>".json_encode($course));
          echo json_encode($course);
          unset($course);
    }
    //Crée un parcour.
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
        "hashCode"=>htmlspecialchars($this->generatehash()),
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
          //On récupère le nom du jeu.
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

        //Met à jour un parcour.
        function updateParcour(){ //TODO ajouter les activités qui n'ont pas d'id. ajouter? quels positions/ ajouter les parcour qui n'ont pas d'id
          $course = json_decode($_POST["parcours"]);

          //toto on vérifie si il y à des éléments à supprimer.
          if(isset($course->rem)) $this->deleteElements($course->rem, null);
          //On crée le parcour
          $course_params = array("codePa"=>htmlspecialchars($course->codePa),
            "createur"=>htmlspecialchars($course->createur),
            "nomPa"=>htmlspecialchars($course->nomPa),
            "descriptionPa"=>substr(htmlspecialchars($course->descriptionPa), 0, 64000),
            "dateCreation"=>htmlspecialchars($course->dateCreation),
            "dateDerniereModif"=>htmlspecialchars(date('Y-m-d')),
            "hashCode"=>htmlspecialchars($course->hashCode),
          ); 
          $parcour = new Course($course_params);  
          //On met à jour le parcour.
          Parcour::updateParcour($parcour,array("codePa" => $parcour->getCodePa()));
          //On bloque l'historique pour ce parcour pour éviter les reprises qui ne fonctionnent pas.
            //On récupère le datetime.
          date_default_timezone_set('Europe/Paris');
          $date = date('Y-m-d H:i:s');
            //On contruit l'array hydrateur histo param.
          $historique_params = array('joueur'=>htmlspecialchars($course->createur),'parcour'=>htmlspecialchars($course->codePa),'step'=>0,'position'=>NULL,'time'=>htmlspecialchars($date));
          $historique = new HistoParcour($historique_params);
            //On envoie l'historique de rupture.
          Parcour::persistParcourHisto($historique);
          //On met à jour les points.
          foreach($course->positions as $point){ 
            //TODO est ce que la position est nouvelle ou pas
            isset($point->parcour)?
              //On crée la position
              $position_params = array("codePo"=>htmlspecialchars($point->codePo),
              "parcour"=>htmlspecialchars($point->parcour),
              "nomPo"=>htmlspecialchars($point->nomPo),
              "pays"=>htmlspecialchars($point->pays),
              "latitude"=>(float)$point->coord[0],
              "longitude"=>(float)$point->coord[1],
             ) 
            :  //On crée la position
                $position_params = array("parcour"=>htmlspecialchars($course->codePa),
                  "nomPo"=>htmlspecialchars($point->nomPo),
                  "pays"=>htmlspecialchars($point->pays),
                  "latitude"=>(float)$point->coord[0],
                  "longitude"=>(float)$point->coord[1],
                )
            ;
           $position = new Point($position_params);
           //On récupère l'id de la position insérée pour l'insertion des activités.  
           if($position->getCodePo()!==null){
            Position::updatePosition($position, array("codePo"=>$position->getCodePo()));
            $idPosition = $position->getCodePo();
           }else{
            $idPosition = Position::persistPosition($position);
            $idPosition = (int)$idPosition->fetch(Fetch::_ASSOC)["LAST_INSERT_ID()"];
           }
           //On ajoute les activités.
           if(empty($point->activites))continue;
           foreach($point->activites as $activity){
              $activ_params = (array)$activity;
              //On récupère le nom du jeu.
              $typeActiv = array_shift($activ_params);
              //On crée l'objet.
              $typeActivObj = 'Projet_Web_parcours\Entities\\'.ucfirst($typeActiv);
              $activ = new $typeActivObj($activ_params);
              if($activ ->getId()!==null){
                Activite::updateActiviteGame($typeActiv, $activ, array("id"=>$activ ->getId()));//TODO On met à jour le parcour et on à son id, faire le crud du cote model parent.
              }else{
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
        }
        function deleteParcour(){
          // die("Nous voulons supprimer le parcour =>".$_POST['idDeleteParcour']);
          $idparcour = isset($_POST['idDeleteParcour'])?$_POST['idDeleteParcour']:null;
          if(!isset($idparcour))return;
          //On vas chercher toutes les positions du parcour et on contruit l'objet avec true.
          
          $deleteTab = array();
          //On vas chercher toutes les positions tu parcour.
          $position_request = Position::existPosition(array("parcour"=>$idparcour), array('codePo'), order: array('codePo'));
          while ($positionCodes = $position_request->fetch(Fetch::_ASSOC)){
            $deleteObj = new stdClass();
            $deleteObj->delete = true;
            $deleteObj->codePo = $positionCodes['codePo'];
            array_push($deleteTab, $deleteObj);
          }
          //On ajoute le code du parcour
          $this->deleteElements($deleteTab);
          Parcour::deleteParcour(array("codePa"=>$idparcour));
          unset($deleteObj);
          unset($deleteTab);
          header('Location: '.Settings::RACINE.'');
        }

        function deleteElements($remove){
          // die("Le tableau des éléments à supprimer est =>" .var_dump($remove));
          if(sizeof($remove) > 0){
            foreach($remove as $element){
              if($element->delete){
                //On supprimer tous les elements de la position.
                $codePosition = $element->codePo;
                //1 On récupère les id des activite à supprimer pour historique activite.
                $activites_request_Histo = Activite::existActivity(array('position' => $codePosition), what: array("codeAct"));
                $idsactiv = $activites_request_Histo->fetchAll();
                //On supprime les historique de l'activite.
                foreach($idsactiv as $activiteCode){
                  Activite::deleteActiviteHisto(array("activite"=>$activiteCode->codeAct));
                }
                //2 On récupère les id des activiteGame à supprimer.
                $activites_request_game = Activite::existActivity(array('position' => $codePosition), what: array("activite", "activiteType", "codeAct"));
                $idsactivGame = $activites_request_game->fetchAll();
                //3 On supprime toutes les activités recensées.
                Activite::deleteActivite(array("position"=>$codePosition));       
                //4 On supprime les activiteGame et les historique activité.
                foreach($idsactivGame as $idactGame){
                  Activite::deleteActiviteGame($idactGame->activiteType, array("id"=>$idactGame->activite));
                  Activite::deleteActiviteHisto(array("activite"=>$idactGame->codeAct));
                }
                //5 On supprime les historique de parcour faisant reference à cette position.
                Parcour::deleteParcourHisto(array("position"=>$codePosition));
                //6 On supprime la position.
                Position::deletePosition(array("codePo"=>$codePosition));
                
              }else{
                //On supprime activité par activité, dabord dans la table activité, puis dans la table respective de chaque jeu.
                foreach($element->activites as $activite){
                  $codeActivite = $activite->id;
                  $nomActivite = $activite->nomAc;
                  Activite::deleteActivite(array("activite"=>$codeActivite));  
                  Activite::deleteActiviteGame($nomActivite, array("id"=>$codeActivite));
                  Activite::deleteActiviteHisto(array("activite"=>$codeActivite));
                }
              }
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