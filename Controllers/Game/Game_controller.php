<?php 
 class Game_controller{
    function createGuest(){
        //Creer une session visiteur pour les visiteurs ? Comment faire perdurer les informations visiteur quand on change de page ? 
        session_start();
        //Calculer le visiteur " Vous etre le n eme visiteur "
        $_SESSION["Visiteur"] = rand(0, 15);
            require('Views/Main/mainpage_view.php');
            // require('Views/Main/main_vue.php'); 
            // require('Views/Login/butdeconnection_vue.php');
    }
 }
