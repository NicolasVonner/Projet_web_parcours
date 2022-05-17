<?php 

 class Game_controller{

    //TODO Charger les informations utilisateur et les implenter dans la vue +  faire des fonction de mise à jour des infos du menbres + static?
    static function launchParcourGame($test){
        require('Views/Authentification/signin_view.php');
        die("Ici on lance le parcour avec l'id : ".$test[0]);
    }
 }
