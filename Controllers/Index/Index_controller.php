<?php 
 class Index_controller{
    function verifyConnection(){
        session_start();
        if(!isset($_SESSION['login'])){
            require('Views/Main/mainpage_view.php');
            //require('Views/Login/forpage_vue.php');
        }else {
            //On affiche l'interface de jeu Acceuil avec les infos session (autre controlleur)
            require('Views/Main/mainpage_view.php');
            // require('Views/Main/main_vue.php'); 
            // require('Views/Login/butdeconnection_vue.php');
        }
    }
 }
