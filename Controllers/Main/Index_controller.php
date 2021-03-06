<?php 

// namespace Projet_Web_parcours\Controllers;
use Projet_Web_parcours\Models\Utilisateur;
use Projet_Web_parcours\Models\Parcour;
use Projet_Web_parcours\Models\Position;
use Projet_Web_parcours\Models\Note;
use Projet_Web_parcours\Entities\User;
use Projet_Web_parcours\Entities\Course;
use Projet_Web_parcours\Entities\Point;
use Projet_Web_parcours\Assets\enums\request\Fetch;
use Projet_Web_parcours\Assets\settings\Settings;

 class Index_controller{

    function rootDirection($utilisateur = null){
        
        //On supprime l'éventuel step sauvegardé
        if(isset($_SESSION['game'])){
            $_SESSION['game'] = null;
        }
        //Si c'est une recherche de parcour de la par d'un user.
        $gameSearch = isset($_POST['gameSearch']) ? true: false;

        //On vérifie si utilisateur est un array => TODO bug à corriger.
        if(is_array($utilisateur)) $utilisateur = null;
            if($this->is_session_started() && !isset($utilisateur)){      
                //On vas chercher les infos du user par rapport à la session en cour.
                $correspondance_array = Utilisateur::existUser(array('username' => $_SESSION['username']));
                if($correspondance_array->rowCount() != 0){
                    $utilisateur_params = $correspondance_array->fetch(Fetch::_ASSOC);
                    $utilisateur = new User($utilisateur_params);
                }
                //On vas chercher les infos du user par rapport à la session en cour.
            }
            //On charge tous ses parcours
            $parcour_board = $this->getParcourBoardDatas($utilisateur, $gameSearch); //TODO variables même nom, changer ça.

            require('Views/Acceuil/acceuilView.php'); 
        }

        function getParcourBoardDatas($utilisateur, $gameSearch){
            $parcour_board = array();

            $where = isset($utilisateur) && !$gameSearch ? array('createur' => $utilisateur->getCodeM()) :null;
            $parcour_array = Parcour::existParcour($where, array('codePa', 'createur', 'nomPa', 'dateCreation', 'hashCode', 'activation'));
    
            while($parcour_params = $parcour_array->fetch(Fetch::_ASSOC)){
                //Crée objet de slection global pour la vue.
                $courses = new stdClass();
                //On modifie l'array hydrateur pour ajouter le réel username.
                $username_createur = Utilisateur::existUser(array('codeM'=>$parcour_params['createur']), array('username'));
                $username = $username_createur->fetch(Fetch::_ASSOC);
                $parcour_params['createur'] = $username['username'];
                //On crée et place l'objet parcour dans l'objet de selection global.
                $parcour = new Course($parcour_params);
                $courses->parcour = $parcour;
                //On récupère le createur

                //On récupère la moyenne
                $note_list_request = Note::existNote(array("codePa"=> $parcour_params['codePa']));
                $note_list = $note_list_request->fetchAll();
                $notes = array_map(
                  function($x) {
                      return $x->note;
                  }, $note_list
                );
                if(count($notes)) {
                    $courses->averageNotes = array_sum($notes)/count($notes);
                }
                else {
                    $courses->averageNotes = null;
                }
    
                //On récupère la première position.
                $position_array = Position::existPosition(array('parcour'=> $courses->parcour->getCodePa()), array('nomPo', 'pays'));
                $position_params = $position_array->fetch(Fetch::_ASSOC);
                $position = new Point($position_params); 
                $courses->position = $position;
                //On récupère le nombre de positions pour ce parcour.
                $steps_params = Position::existPosition(array('parcour'=> $courses->parcour->getCodePa()), array('COUNT(*) AS steps')); 
                $courses->steps = (int)$steps_params->fetch(Fetch::_ASSOC)["steps"];
    
                array_push($parcour_board, $courses);
                unset($courses);
            }
            return $parcour_board;
        }
    
    //TODO faire des unset ou des sessions_destroy
    function logout(){
        $_SESSION['username'] = null;
        //session_destroy(); //destroy the session
         header('Location: '.Settings::RACINE.''); //to redirect back to "index.php" after logging out
    }

    function is_session_started()
    {
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
             return session_status() === PHP_SESSION_ACTIVE && isset($_SESSION["username"])? TRUE : FALSE;
            } else {
                return session_id() === '' && $_SESSION["username"] !== null? FALSE : TRUE;
            }
        }
        return FALSE;
    }
 }