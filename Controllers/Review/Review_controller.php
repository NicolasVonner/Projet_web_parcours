<?php 
// namespace App\Controllers;
use Projet_Web_parcours\Models\Note;
use Projet_Web_parcours\Models\Utilisateur;
use Projet_Web_parcours\Models\Parcour;
use Projet_Web_parcours\Entities\User;
use Projet_Web_parcours\Entities\Review;
use Projet_Web_parcours\Assets\enums\request\Fetch;
use Projet_Web_parcours\Assets\settings\Settings;

//TODO mettre un namespace et appeler la classe par cette intermediaire
//problème avec l'index..

//use Projet_Web_parcours\Controllers\Index_controller;
require('Controllers/Main/Index_controller.php');
class Review_controller extends Index_controller{  

    function displayReviewPage(){
      //Le visiteur peut consulter le classement pour un parcour.
      if(!$this->is_session_started() || !isset($_POST['codePa'])){
        header('Location: '.Settings::RACINE.'');
        return;
      }else{
        $correspondance_array = Utilisateur::existUser(array('username' => $_SESSION['username']));
        if($correspondance_array->rowCount() != 0){
            $utilisateur_params = $correspondance_array->fetch(Fetch::_ASSOC);
            $utilisateur = new User($utilisateur_params); 
        } else{
            header('Location: '.Settings::RACINE.'');
            return;
        }    
        // On crée un tableau de review
        $reviewBox = [];

        $codePa = $_POST['codePa'];
        $note_list_request = Note::existNote(array("codePa"=> $codePa));
        $note_list = $note_list_request->fetchAll();

        $parcour_name_stmt = Parcour::existParcour(array("codePa"=>$codePa));
        $nomParcour = $parcour_name_stmt->fetch(Fetch::_ASSOC)["nomPa"];
        foreach($note_list as $note) {
          $review = array(
            "avatar"=>$utilisateur->getAvatar(),
            "username"=>$utilisateur->getUsername(),
            "note"=>$note->note,
            "commentaire"=>$note->commentaire
          );
          $reviewBox[] = $review;
        }
      }
      require('Views/Review/review_view.php'); //TODO require la vue.
    }

}
?>