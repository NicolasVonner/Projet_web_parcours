<?php 

// namespace Projet_Web_parcours\Controllers;
use Projet_Web_parcours\Entities\Session;
use Projet_Web_parcours\Models\Utilisateur;
use Projet_Web_parcours\Entities\User;
use Projet_Web_parcours\Assets\enums\request\Fetch;

 class Index_controller{

    function rootDirection($utilisateur = null){
        //On vérifie si utilisateur est un array => TODO bug à corriger.
       if(is_array($utilisateur)) $utilisateur = null;
            if($this->is_session_started() && !isset($utilisateur)){            
                //On vas chercher les infos du user par rapport
                $correspondance_array = Utilisateur::existUser(array('username' => $_SESSION['username']));
                if($correspondance_array->rowCount() != 0){
                    $utilisateur_params = $correspondance_array->fetch(Fetch::_ASSOC);
                    $utilisateur = new User($utilisateur_params); 
                }
            } 
            //TODO faire les boucle d'itération de l'objet dans la vue.
            require('Views/Acceuil/acceuilView.php'); 
    }
    
    //TODO faire des unset ou des sessions_destroy
    function logout(){
        $_SESSION['username'] = null;
        //session_destroy(); //destroy the session
         header('Location: http://fastadventure/'); //to redirect back to "index.php" after logging out
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